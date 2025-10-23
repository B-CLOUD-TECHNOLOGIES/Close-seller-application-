<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display all notifications for logged-in vendor.
     */
    public function index()
    {
        $vendor = Auth::guard('vendor')->user();

        $notifications = notification::where('user_id', $vendor->id)
            ->where('user_type', 'vendor')
            ->orderBy('id', 'desc')
            ->get();

        return view('vendors.notification.index', compact('notifications'));
    }

    /**
     * Show details for a single notification.
     */
    public function show($id)
{
    $vendor = auth()->guard('vendor')->user();

    $notification = notification::where('id', $id)
        ->where('user_id', $vendor->id)
        ->where('user_type', 'vendor')
        ->firstOrFail();

    // Mark as read if not already
    if (!$notification->is_read) {
        $notification->update(['is_read' => true]);
    }

    return view('vendors.notification.notification-details', compact('notification'));
}

    /**
     * Mark all vendor notifications as read.
     */
    public function markAllAsRead()
    {
        $vendor = Auth::guard('vendor')->user();

        notification::where('user_id', $vendor->id)
            ->where('user_type', 'vendor')
            ->update(['is_read' => true]);

        return response()->json(['status' => 'success', 'message' => 'All notifications marked as read']);
    }
}
