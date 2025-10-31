<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelpController extends Controller
{
   public function index()
    {
        // You can define static contact info here since you don’t want database
        $settings = (object) [
            'email' => 'info@closesellertv.com.ng',
            'phone' => '+234777666222',
        ];

        return view('vendors.customerSupport.gethelp', compact('settings'));
    }

    public function customerSupport()
    {
        return view('vendors.customerSupport.index');
    }   

    public function sendFeedback()
    {
        return view('vendors.customerSupport.sendfeedback');
    }
    public function sendReport()
    {
        return view('vendors.customerSupport.report');
    }

     public function storeFeedback(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $vendor = auth('vendor')->user();

        Feedback::create([
            'user_id' => $vendor->id, // for logged-in vendors
            'topic' => $request->topic,
            'type' => 'Vendor', // optional, could be “suggestion” etc.
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Feedback submitted successfully'], 200);
    }

     public function storeReport(Request $request)
    {
        $request->validate([
            'issue' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $vendor = auth('vendor')->user();

        Tickets::create([
            'user_id' => $vendor->id, // for logged-in vendors
            'topic' => $request->issue,
            'type' => 'Vendor', // optional, could be “suggestion” etc.
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Report submitted successfully'], 200);
    }
}
