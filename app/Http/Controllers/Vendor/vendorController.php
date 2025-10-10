<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\vendorVerification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;


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

    public function VendorDashboard(){
        return view('vendors.index');
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
