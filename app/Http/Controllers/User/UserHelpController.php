<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Feedback;
use App\Models\Tickets;
use Illuminate\Http\Request;

class UserHelpController extends Controller
{
    //
    public function customerSupport()
    {
        return view('users.customerSupport.index');
    }


    public function sendFeedback()
    {
        return view('users.customerSupport.sendfeedback');
    }

    public function storeFeedback(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $user = auth('web')->user();

        Feedback::create([
            'user_id' => $user->id, // for logged-in users
            'topic' => $request->topic,
            'type' => 'User', // optional, could be “suggestion” etc.
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Feedback submitted successfully'], 200);
    }


    public function Faqs()
    {
        // Group FAQs by category
        $faqs = Faq::orderBy('category')->get()->groupBy('category');

        return view('users.faqs.faq', compact('faqs'));
    }

    public function getHelp()
    {
        // You can define static contact info here since you don’t want database
        $settings = (object) [
            'email' => 'info@closesellertv.com.ng',
            'phone' => '+234777666222',
        ];

        return view('users.customerSupport.gethelp', compact('settings'));
    }


    public function sendReport()
    {
        return view('users.customerSupport.report');
    }

    public function storeReport(Request $request)
    {
        $request->validate([
            'issue' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $user = auth('web')->user();

        Tickets::create([
            'user_id' => $user->id, // for logged-in users
            'topic' => $request->issue,
            'type' => 'User',
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Report submitted successfully'], 200);
    }
}
