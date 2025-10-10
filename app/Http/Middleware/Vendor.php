<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Vendor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('vendor')->check()) {
            $notification = [
                'message' => 'You do not have permission to access this page',
                'alert-type' => 'error'
            ];
            return redirect()->route("vendor.login")->with($notification);
        }
        return $next($request);
    }
}
