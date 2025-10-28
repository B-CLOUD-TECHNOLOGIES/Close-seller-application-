<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class userOrderController extends Controller
{
    //
    public function usersOrders(){
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        if($user){
            // get the orders
            $data["orders"] = Orders::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();

            Log::info('data: ' .$data['orders']);
        }
    }
}
