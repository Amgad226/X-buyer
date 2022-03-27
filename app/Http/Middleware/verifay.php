<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class verifay
{
   
    public function handle(Request $request, Closure $next)
    {
      

        if (Auth::user()->email_verified!=1)
        { 
        return response()->json(['message'=>'you must verifay your email ']);
        }
        
        return $next($request);
    }
}
