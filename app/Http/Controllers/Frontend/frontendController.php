<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\categories;
use App\Models\notification;
use App\Models\productColors;
use App\Models\productImages;
use App\Models\products;
use App\Models\productSizes;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class frontendController extends Controller
{
    // Onboarding 
    public function Onboarding()
    {
        return view("onboarding");
    }

    // Auth Type
    public function AuthType()
    {
        return view('auth-select');
    }

    // Auth Type
    public function SplashScreen()
    {
        return view("splash-screen");
    }

    public function Home()
    {
        // bring out the notification count for the user
        // bring out the nessage count for the user
        // bring out the cart count count for the user

        // all added to the frontend master page

        $data['categories'] = categories::inRandomOrder()->where('status', 1)->where('isdelete', 0)->get();
        $data['adminProducts'] = products::where('product_owner', 'Admin')
            ->where('status', 1)
            ->where('isdelete', 0)
            ->get();
        $data['products'] = products::where('product_owner', 'Vendor')
            ->where('status', 1)
            ->where('isdelete', 0)
            ->orderBy('updated_at', 'DESC')
            ->get();


        return view("frontend.index", $data);
    }


    public function ProductDetails($productid, $productName, $catid, $catName)
    {
        $product = $data['product'] = products::where('id', $productid)->where('status', 1)->where('isdelete', 0)->first();

        if (!$data['product']) {
            $notification = array(
                'message' => 'Product not found',
                'alert-type' => 'error'
            );
            return redirect()->route('index')->with($notification);
        }


        // get all the product Images
        $data['productImages'] = productImages::where('product_id', $productid)
            ->orderBy('order_by', 'ASC')
            ->get();

        // get the vendor or admin details
        if (!empty($product->product_owner) && $product->product_owner == "Vendor") {
            $vendor = Vendor::where('id', $product->vendor_id)->first();
            $vendorName = !empty($vendor->username) ? $vendor->username : $vendor->firstname;
            $vendorType = "Vendor";
            $data['vendorName'] = $vendorName;
            $data['vendorType'] = $vendorType;
            $data['vendor'] = $vendor;
        } else {
            $data['vendorName'] = 'Closeseller';
            $data['vendorType'] = 'Admin';
            // modify this later to get admin details
        }

        // get all sizes for the product
        $data['productSizes'] = productSizes::where('product_id', $productid)->get();

        // get all colors for the product
        $data['productColors'] = productColors::where('product_id', $productid)->get();


        $data['relatedProducts'] = products::where('id', '!=', $productid)
            ->where('status', 1)
            ->where('isdelete', 0)
            ->inRandomOrder()
            ->get();



        return view("frontend.product-details", $data);
    }



    public function ProductCategories($catid, $catName)
    {
        $category = $data['category'] =  categories::where('id', $catid)->where('status', 1)->where('isdelete', 0)->first();

        if (!$data['category']) {
            $notification = array(
                'message' => 'Category not found',
                'alert-type' => 'error'
            );
            return redirect()->route('index')->with($notification);
        }

        $data['products'] = products::where('category_id', $catid)
            ->where('status', 1)
            ->where('isdelete', 0)
            ->orderBy('updated_at', 'DESC')
            ->get();


        $data['otherProducts'] = products::where('category_id', '!=', $catid)
            ->where('status', 1)
            ->where('isdelete', 0)
            ->inRandomOrder()
            ->get();

        $data['pageName'] = $category->category_name;

        return view("frontend.product-categories", $data);
    }



    public function categories()
    {
        $data["categories"] = categories::inRandomOrder()->get();

        return view('frontend.categories', $data);
    }


    public function productSearch(Request $request)
    {
        $query = $request->input('search');
        $products = $data['products'] = products::where('status', 1)
            ->where(function ($q) use ($query) {
                $q->where('product_name', 'LIKE', "%{$query}%")
                    ->orWhere('location', 'LIKE', "%{$query}%")
                    ->orWhere('city', 'LIKE', "%{$query}%")
                    ->orWhereJsonContains('tags', $query); // works if tags is a JSON array
            })
            ->get();

        // get the name of the page
        $count = $products->count();
        $data['pageName'] = $count . ' ' . Str::plural('Result', $count) . ' on ' . $query;


        //  related products not under the search query
        $search = $query; // assuming $query holds the search keyword

        $data['otherProducts'] = products::where('status', 1)
            ->where('isdelete', 0)
            ->where(function ($q) use ($search) {
                $q->where('product_name', 'NOT LIKE', "%{$search}%")
                    ->where('location', 'NOT LIKE', "%{$search}%")
                    ->where('city', 'NOT LIKE', "%{$search}%")
                    ->when(DB::getSchemaBuilder()->hasColumn('products', 'tags'), function ($queryBuilder) use ($search) {
                        $queryBuilder->where(function ($t) use ($search) {
                            $t->whereJsonDoesntContain('tags', $search)
                                ->orWhereNull('tags');
                        });
                    });
            })
            ->inRandomOrder()
            ->get();



            return view('frontend.product-search', $data);
    }



    public function AuthNotification(){
        //  I added the codes already in app/providers/appserviceproviders
        return view('frontend.notification.notification-list');
    }


    public function notificationDetails($id){
        $notify  = notification::getSingle($id);
        $notify->is_read = 1;
        $notify->save();

        $data['notify'] = $notify;

        return view('frontend.notification.notification-details', $data);
    }


}
