<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Vendor;
use App\Models\notification;


class VendorPasswordController extends Controller
{
    /**
     * Show the change password page.
     */
    public function showChangePasswordForm()
    {
        return view('vendors.settings.change-password'); // your Blade file
    }
    /**
     * Handle password change request.
     */
   public function updatePassword(Request $request)
{
    $request->validate([
        'old_password' => 'required|string',
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    $vendorId = Auth::guard('vendor')->id();
    $vendor = Vendor::find($vendorId);

    if (!$vendor) {
        return response()->json([
            'status' => false,
            'message' => 'Vendor not found or not authenticated.',
        ], 404);
    }

    if (!Hash::check($request->old_password, $vendor->password)) {
        return response()->json([
            'status' => false,
            'message' => 'Old password is incorrect.',
        ]);
    }

    $vendor->password = Hash::make($request->new_password);
    $vendor->save();

    // ✅ Create notification using the helper
    notification::insertRecord(
        $vendor->id,
        'vendor',
        'Password Changed',
        '/vendor/profile/security',
        'Your account password was successfully changed on ' . now()->format('M d, Y H:i A'),
        false
    );

    return response()->json([
        'status' => true,
        'message' => 'Password changed successfully!',
    ]);
}

    }
