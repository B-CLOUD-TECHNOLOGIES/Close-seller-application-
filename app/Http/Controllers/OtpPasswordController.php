<?php

namespace App\Http\Controllers;

use App\Mail\SendPasswordOtpMail;
use App\Models\PasswordOtp;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class OtpPasswordController extends Controller
{




    // ===================== USER PASSWORD RESET WITH OTP ================== //

    public function UserResetPassword(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            // Find the user
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return back()->withErrors(['email' => 'User not found.']);
            }

            // Update the password
            $user->password = Hash::make($request->password);
            $user->save();

            // Optional: Delete OTP record (if you're using OTP-based verification)
            PasswordOtp::where('email', $request->email)->delete();

            // Notification message
            $notification = [
                'message' => 'Password has been reset successfully! You can now log in.',
                'alert-type' => 'success'
            ];

            // Redirect to login page
            return redirect()->route('login')->with($notification);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Something went wrong. Please try again later.']);
        }
    }


    public function UserResetForm($email, Request $request)
    {
        return view('auth.reset-password', compact('email'));
    }


    // Step 1: Send OTP
    public function UsersendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);

        // Store it in the database (overwrite any existing)
        PasswordOtp::updateOrCreate(
            ['email' => $request->email],
            ['otp' => $otp, 'expires_at' => Carbon::now()->addMinutes(1)]
        );

        // Send OTP to email
        $subject = "Your OTP Verification Code";
        $body = "
            <h5>Your One-Time Password (OTP) for verification is:</h5>
            <h2 style='color:#713899; font-size:32px; letter-spacing: 3px;'>$otp</h2>
            <p>This OTP is valid for the next 10 minutes. Please do not share it with anyone.</p>
        ";

        Mail::to($request->email)->send(new SendPasswordOtpMail($subject, $body));


        $notification = array(
            'message' => 'We have sent you a 6 digit OTP code to your email.',
            'alert-type' => 'info'
        );


        return redirect()->route('user.password.otp.verify.page', ['email' => $request->email])
            ->with($notification);
    }



    function UserverifyOtpPage($email)
    {
        return view('auth.otp-verify', compact('email'));
    }


    // Step 2: Verify OTP
    public function UserverifyOtp(Request $request)
    {
        // Combine OTP digits into one value
        $otp = $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4 . $request->otp5 . $request->otp6;

        // Merge combined OTP into the request for validation
        $request->merge(['otp' => $otp]);

        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $otpRecord = PasswordOtp::where('email', $request->email)
            ->where('otp', $otp)
            ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        if (Carbon::parse($otpRecord->expires_at)->isPast()) {
            return back()->withErrors(['otp' => 'OTP expired.']);
        }

        // ✅ OTP is valid — redirect to password reset form
        return redirect()->route('user.password.reset.form', ['email' => $request->email]);
    }




    //  =============================== VENDOR PASSWORD RESET WITH OTP ================== //
    public function VendorForgotPassword()
    {
        return view('vendors.auth.forgot-password');
    }



    public function VendorForgotPasswordOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:vendors,email']);

        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);

        // Store it in the database (overwrite any existing)
        PasswordOtp::updateOrCreate(
            ['email' => $request->email],
            ['otp' => $otp, 'expires_at' => Carbon::now()->addMinutes(10)]
        );

        // Send OTP to email
        $subject = "Your OTP Verification Code";
        $body = "
            <h5>Your One-Time Password (OTP) for verification is:</h5>
            <h2 style='color:#713899; font-size:32px; letter-spacing: 3px;'>$otp</h2>
            <p>This OTP is valid for the next 10 minutes. Please do not share it with anyone.</p>
        ";

        Mail::to($request->email)->send(new SendPasswordOtpMail($subject, $body));

        $notification = array(
            'message' => 'We have sent you a 6 digit OTP code to your email.',
            'alert-type' => 'info'
        );

        return redirect()->route('vendor.password.otp.verify.page', ['email' => $request->email])
            ->with($notification);
    }


    public function VendorverifyOtpPage($email)
    {
        return view('vendors.auth.otp-verify', compact('email'));

    }


    public function VendorverifyOtp(Request $request)
    {
        // Combine OTP digits into one value
        $otp = $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4 . $request->otp5 . $request->otp6;

        // Merge combined OTP into the request for validation
        $request->merge(['otp' => $otp]);

        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $otpRecord = PasswordOtp::where('email', $request->email)
            ->where('otp', $otp)
            ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        if (Carbon::parse($otpRecord->expires_at)->isPast()) {
            return back()->withErrors(['otp' => 'OTP expired.']);
        }

        // ✅ OTP is valid — redirect to password reset form
        return redirect()->route('vendor.password.reset.form', ['email' => $request->email]);
    }


    public function VendorResetForm($email, Request $request)
    {
        return view('vendors.auth.reset-password', compact('email'));
    }


    public function VendorResetPassword(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email|exists:vendors,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            // Find the user
            $user = Vendor::where('email', $request->email)->first();

            if (!$user) {
                return back()->withErrors(['email' => 'Vendor not found.']);
            }

            // Update the password
            $user->password = Hash::make($request->password);
            $user->save();

            // Optional: Delete OTP record (if you're using OTP-based verification)
            PasswordOtp::where('email', $request->email)->delete();

            // Notification message
            $notification = [
                'message' => 'Password has been reset successfully! You can now log in.',
                'alert-type' => 'success'
            ];

            // Redirect to login page
            return redirect()->route('vendor.login')->with($notification);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Something went wrong. Please try again later.']);
        }
    }
}
