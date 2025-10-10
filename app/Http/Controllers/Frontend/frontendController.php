<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class frontendController extends Controller
{
    // Onboarding 
    public function Onboarding(){
        return view("onboarding");
    }

    // Auth Type
    public function AuthType(){
        return view('auth-select');
    }
    
    // Auth Type
    public function SplashScreen(){
        return view("splash-screen");
    }

    public function Home(){
        return view("frontend.index");
    }
}
