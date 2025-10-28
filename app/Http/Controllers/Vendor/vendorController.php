<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\VendorVerification;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class vendorController extends Controller
{


    public function VendoLlogout(){
        Auth::guard('vendor')->logout();
        $notification = [
            'message' => 'You have Successfully Logged out',
            'alert-type' => 'success'
        ];
        return redirect()->route('vendor.login')->with($notification);
    }

    public function VendorSettings(){
        return view('vendors.settings');
    }

     public function VendorPersonalData()
    {
        $vendor = auth('vendor')->user(); // Fetch logged-in vendor
        return view('vendors.settings.personal-data', compact('vendor'));
    }

    public function VendorBusinessInfo()
    {
        $vendor = auth('vendor')->user();
        $businessInfo = VendorVerification::where('vendor_id', $vendor->id)->first();

        return view('vendors.settings.business-information', compact('vendor', 'businessInfo'));
    }


// public function VendorUpdatePersonalData(Request $request)
// {
//     $vendor = Vendor::find(auth('vendor')->id());

//     $request->validate([
//         'firstname' => 'required|string|max:255',
//         'lastname' => 'required|string|max:255',
//         'phone' => 'required|string|max:20',
//         'gender' => 'nullable|string|max:50',
//         'image' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
//     ]);

//     // Handle image upload
//     if ($request->hasFile('image')) {
//         $file = $request->file('image');
//         $fileName = time().'_'.$file->getClientOriginalName();
//         $filePath = $file->storeAs('uploads/vendors', $fileName, 'public');
//         $vendor->image = $filePath;
//     }

//     // Update vendor data
//     $vendor->firstname = $request->firstname;
//     $vendor->lastname = $request->lastname;
//     $vendor->phone = $request->phone;
//     $vendor->gender = $request->gender;
//     $vendor->save();

//     // ✅ Create a notification record
//     \App\Models\Notification::create([
//         'vendor_id' => $vendor->id,
//         'title' => 'Profile Updated',
//         'message' => 'Your personal information was updated successfully on ' . now()->format('M d, Y H:i A'),
//     ]);

//     return back()->with('success', 'Profile updated successfully!');
// }
public function VendorUpdatePersonalData(Request $request)
{
    try {
        $vendor = Vendor::find(auth('vendor')->id());

        if (!$vendor) {
            return response()->json([
                'success' => false,
                'message' => 'Vendor not found.'
            ], 404);
        }

        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'phone'     => 'required|string|max:20',
            'gender'    => 'nullable|string|max:50',
            'image'     => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ]);

        // ✅ Handle profile image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $extension = strtolower($image->getClientOriginalExtension());
            $allowed = ['jpeg', 'jpg', 'png', 'gif', 'webp'];

            if (in_array($extension, $allowed)) {
                $uniqueName = hexdec(uniqid()) . '.' . $extension;
                $uploadPath = 'uploads/vendor-profile/' . $uniqueName;

                // ✅ Resize and save to public folder
                $manager = new ImageManager(new Driver());
                $img = $manager->read($image);
                $img->resize(250, 250);
                $img->save(public_path($uploadPath));

                // ✅ Delete old image (optional but recommended)
                if (!empty($vendor->image) && file_exists(public_path($vendor->image))) {
                    @unlink(public_path($vendor->image));
                }

                $vendor->image = $uploadPath;
            }
        }

        // ✅ Update vendor info
        $vendor->firstname = $request->firstname;
        $vendor->lastname  = $request->lastname;
        $vendor->phone     = $request->phone;
        $vendor->gender    = $request->gender;
        $vendor->save();

        // ✅ Create notification using helper method
        notification::insertRecord(
            $vendor->id,
            'vendor',
            'Profile Updated',
            '/vendor/profile',
            'Your personal information was updated successfully on ' . now()->format('M d, Y H:i A'),
            false
        );

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!',
            'vendor' => $vendor
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error updating profile: ' . $e->getMessage(),
        ], 500);
    }
}


public function VendorUpdateBusinessInfo(Request $request)
{
    try {
        $vendor = auth('vendor')->user();

        if (!$vendor) {
            return response()->json([
                'success' => false,
                'message' => 'Vendor not found.'
            ], 404);
        }

        // ✅ Validate request
        $request->validate([
            'businessName' => 'required|string|max:255',
            'description'  => 'required|string|max:500',
            'website'      => 'nullable|url|max:255',
            'address'      => 'required|string|max:255',
        ]);

        // ✅ Find or create vendor verification record
        $verification = VendorVerification::firstOrNew(['vendor_id' => $vendor->id]);

        // ✅ Update fields
        $verification->name        = $request->businessName;
        $verification->description = $request->description;
        $verification->web_url     = $request->website;
        $verification->address     = $request->address;
        $verification->status      = 0; // reset to pending
        $verification->save();

        // ✅ Create notification record
        notification::insertRecord(
            $vendor->id,
            'vendor',
            'Business Information Updated',
            '/vendor/business-info',
            'Your business information was updated successfully on ' . now()->format('M d, Y H:i A'),
            false
        );

        return response()->json([
            'success' => true,
            'message' => 'Business information updated successfully!',
            'data'    => $verification
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error updating business information: ' . $e->getMessage(),
        ], 500);
    }
}


   public function VendorDashboard()
{
    // Get the currently authenticated vendor
    $vendor = auth('vendor')->user();

    if (!$vendor) {
        return redirect()->route('vendor.login')->with('error', 'Please log in first.');
    }

    // Count unread notifications for this vendor
    $unreadNotifications = Notification::where('user_id', $vendor->id)
                            ->where('user_type', 'vendor')
                            ->where('is_read', false)
                            ->count();

    // Pass vendor + unread count to the dashboard
    return view('vendors.index', [
        'vendor' => $vendor,
        'unreadNotifications' => $unreadNotifications
    ]);
}

public function VendorDocStore(Request $request)
{
    $request->validate([
        'question' => ['required', 'string'],
        'video_url' => ['required', 'url'],
        'nin' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'], // Max 2MB
        'cac' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'], // Only required for registered business
    ]);

    // If "question" indicates registered business, CAC becomes mandatory
    if ($request->question == "1" && !$request->hasFile('cac')) {
        return back()->withErrors(['cac' => 'CAC document is required for registered businesses.'])->withInput();
    }

    $vendor = Auth::guard('vendor')->user();

    // Initialize paths
    $ninPath = null;
    $cacPath = null;

    // Upload NIN
    if ($request->hasFile('nin')) {
        $nin = $request->file('nin');
        $ninName = hexdec(uniqid()) . '.' . $nin->getClientOriginalExtension();
        $nin->move(public_path('uploads/vendor_docs/nin'), $ninName);
        $ninPath = 'uploads/vendor_docs/nin/' . $ninName;
    }

    // Upload CAC (only if provided)
    if ($request->hasFile('cac')) {
        $cac = $request->file('cac');
        $cacName = hexdec(uniqid()) . '.' . $cac->getClientOriginalExtension();
        $cac->move(public_path('uploads/vendor_docs/cac'), $cacName);
        $cacPath = 'uploads/vendor_docs/cac/' . $cacName;
    }

    // Save or update vendor verification record
    $verification = VendorVerification::firstOrNew(['vendor_id' => $vendor->id]);

    $verification->question = $request->question;
    $verification->video_url = $request->video_url;
    $verification->nin = $ninPath ?? $verification->nin; // Retain old file if not updated
    $verification->cac = $cacPath ?? $verification->cac; // Retain old file if not updated
    $verification->status = 1; // 1 = Submitted for verification or verified
    $verification->save();

    $notification = [
        'message' => 'Documents submitted successfully. Awaiting verification.',
        'alert-type' => 'success'
    ];

    return redirect()->route('vendor.dashboard')->with($notification);
}

    //
    public function Vendorregister()
    {
        // change to vendor registeration
        return view('vendors.auth.register');
    }


    public function VendorStore(Request $request)
    {
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^\+?[1-9]\d{9,14}$/'], // International format e.g. +234810...
            'about' => ['required', 'string', 'max:500'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:vendors,email'],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        // ✅ Create new vendor
        $vendor = Vendor::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
            'about' => $request->about,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // ✅ Fire registration event
        event(new Registered($vendor));

        // ✅ Login vendor immediately after registration
        Auth::guard('vendor')->login($vendor);

        $notification = [
            'message' => 'Registered Successful',
            'alert-type' => 'success'
        ];

        // ✅ Redirect to vendor dashboard
        return redirect()->route("vendor.doc.verify")->with($notification);
    }


    public function VendorDocumentVerification()
    {
        return view('vendors.auth.document-verification');
    }


    //
    public function VendorLogin() {
        return view('vendors.auth.login');
    }


    public function VendorLoginSubmit(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('vendor')->attempt($credentials)) {
            $request->session()->regenerate();

            $notification = [
                'message' => 'Vendor Login Successful',
                'alert-type' => 'success'
            ];

            return redirect()->route('vendor.dashboard')->with($notification);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');

    }
}
