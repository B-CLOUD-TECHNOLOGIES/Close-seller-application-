<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class userController extends Controller
{
    public function UserDashboard()
    {
        return view("users.profile");
    }


    public function UserLogout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'Successfully Logged out',
            'alert-type' => 'success'
        );

        return redirect('/')->with($notification);
    }
}
