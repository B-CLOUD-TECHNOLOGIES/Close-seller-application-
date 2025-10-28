<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\categories;
use App\Models\Color;
use App\Models\Location;
use App\Models\productColors;
use App\Models\productImages;
use App\Models\products;
use App\Models\productSizes;
use App\Models\Units;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use App\Models\notification;

class VendorProductController extends Controller
{

    public function VendorAddProduct()
    {
        return view('vendors.products.add-product');
    }


    public function VendorCreateProduct(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:100',
        ]);

        $product = new products();
        $product->vendor_id = Auth::guard('vendor')->user()->id;
        $product->title = $request->product_name;
        $product->product_name = $request->product_name;
        $product->product_owner = "Vendor";
        $product->sku = $this->generateSKU($request->product_name);
        $product->old_price = 0;
        $product->new_price = 0;
        $product->stock_quantity = 0;
        $product->status = 1;
        $product->isdelete = 0;
        $product->save();

        $productID = $product->id;
        $notification = array(
            'message' => "Product Sucessfully created Complete your prodduct inforation",
            'alert-type' => 'success'
        );

         // ✅ Create notification using helper method
        notification::insertRecord(
            $product->vendor_id,
            'vendor',
            'New Product Added by Vendor',
            '/vendor/products',
            'You just  has added a new product:' .        $product->title. "on ". now()->format('M d, Y H:i A'),
            false
        );




        return redirect()->route('vendor.edit.product', ['productid' => $productID])->with($notification);
    }


    public function VendorEditProduct($productid)
    {
        if (!$productid) {
            $notification = array(
                'message' => 'Something Went Wrong',
                'alert-type' => 'error'
            );
            return redirect()->route('vendor.add.products')->with($notification);
        }

        $data['product'] = products::where('id', $productid)
            ->where('vendor_id', Auth::guard('vendor')->user()->id)->first();

        $data['units'] = Units::orderBy('unit', 'ASC')->get();
        $data['categories'] = categories::orderBy('category_name', 'ASC')->get();
        $data['locations'] = Location::orderBy('name', 'ASC')->get();
        $data['colors'] = Color::orderBy('color', 'ASC')->get();

        return view('vendors.products.edit-product', $data);
    }
    //


    public function VendorDeleteImage($id)
    {
        $image = productImages::find($id);
        if (!empty($image->getAllImages())) {
            unlink($image->image_name);
        }

        if (!empty($image->getAllZoomImages())) {
            unlink($image->image_zoom);
        }

        $image->delete();
        $notification = [
            'message' => 'Image Successfully Deleted',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }




    public function VendorUpdateProduct(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'new_price' => 'nullable|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // ✅ only images allowed, 2MB max
        ]);

        $request_id = $request->id;
        $product = products::findOrFail($request_id);

        if (empty($request->category_id)) {
            $notification = [
                'message' => 'Please select a category first',
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification);
        }

        $title = trim($request->product_name);

        if (!empty($product)) {
            $product->update([
                'title' => $title,
                'product_name' => $title,
                'category_id' => trim($request->category_id),
                'new_price' => !empty($request->new_price) ? trim($request->new_price) : 0,
                'old_price' => !empty($request->old_price) ? trim($request->old_price) : 0,
                'unit' => trim($request->unit),
                'location' => trim($request->location),
                'city' => trim($request->city),
                'tags' => !empty($request->tags)
                    ? (is_array($request->tags) ? $request->tags : explode(',', $request->tags))
                    : [],
                'description' => trim($request->description),
                'stock_quantity' => !empty($request->stock_quantity)
                    ? trim($request->stock_quantity)
                    : 0,
            ]);

            // 🟡 Delete old colors and add new ones
            productColors::DeleteRecord($product->id);
            if (!empty($request->color_id)) {
                foreach ($request->color_id as $color_id) {
                    productColors::create([
                        'product_id' => $product->id,
                        'color_id' => $color_id,
                    ]);
                }
            }

            // 🟡 Delete old sizes and add new ones
            productSizes::DeleteSizeRecord($product->id);
            if (!empty($request->size)) {
                foreach ($request->size as $size) {
                    if (!empty($size['name'])) {
                        productSizes::create([
                            'name' => $size['name'],
                            'price' => !empty($size['price']) ? $size['price'] : 0,
                            'product_id' => $product->id,
                        ]);
                    }
                }
            }

            // 🟢 Handle product images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    if ($image->isValid()) {
                        $extension = strtolower($image->getClientOriginalExtension());

                        // ✅ Extra check for valid image mime type (safety net)
                        $allowed = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
                        if (!in_array($extension, $allowed)) {
                            continue; // Skip invalid files
                        }

                        $uniqueName = hexdec(uniqid()) . '.' . $extension;
                        $normalPath = 'uploads/products/' . $uniqueName;

                        $manager = new ImageManager(new Driver());
                        $img = $manager->read($image);
                        $img->resize(150, 150);
                        $img->save(public_path($normalPath));

                        productImages::create([
                            'product_id' => $product->id,
                            'image_name' => $normalPath,
                            'image' => $normalPath,
                            'image_extension' => $extension,
                        ]);
                    }
                }
            }

            $notification = [
                'message' => 'Product Successfully Updated',
                'alert-type' => 'success',
            ];

              // ✅ Create notification using helper method
            notification::insertRecord(
                $product->vendor_id,
                'vendor',
                'Product Updated by Vendor',
                '/vendor/products',
                'You updated the product:' .   $product->title. "on ". now()->format('M d, Y H:i A'),
                false
            );

            return redirect()->back()->with($notification);
            //  redirect to the product view page
        } else {
            abort(404);
        }
    }


    public function productImageSort(Request $request)
    {
        if (!empty($request->photo_id)) {
            $i = 1;
            foreach ($request->photo_id as $photo_id) {
                $image = productImages::find($photo_id);
                $image->order_by = $i;
                $image->save();
                $i++;
            }
        }

        // $json['success'] = true;
        // echo json_encode($json);

    return response()->json(['success' => true]);
    }

    public function VendorProducts()
    {
        $vendor = Auth::guard('vendor')->user();

       $activeProducts = products::where('vendor_id', $vendor->id)
            ->where('status', 1)
            ->latest()
            ->get();

        $declinedProducts = products::where('vendor_id', $vendor->id)
            ->where('status', 0)
            ->latest()
            ->get();
        return view('vendors.products.products', compact('activeProducts', 'declinedProducts'));
    }





    private function generateSKU($productName)
    {
        // Remove spaces and non-alphabetic characters
        $cleanName = preg_replace('/[^A-Za-z]/', '', $productName);

        // Fallback if product name is too short
        if (strlen($cleanName) < 3) {
            $cleanName .= Str::random(3);
        }

        do {
            // Shuffle the letters and take 3 random ones from the name
            $lettersFromName = strtoupper(substr(str_shuffle($cleanName), 0, 3));
            // Add a random 4-character alphanumeric string
            $randomPart = strtoupper(Str::random(4));
            // Add a short timestamp part (last 3 digits of current time)
            $timestampPart = substr(time(), -3);
            // Combine all parts
            $sku = $lettersFromName . '-' . $randomPart . $timestampPart;
            // Check if SKU already exists
            $exists = products::where('sku', $sku)->exists();
        } while ($exists); // Regenerate if SKU already exists

        return $sku;
    }
}
