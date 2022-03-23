<?php

namespace App\Http\Middleware;

use App\Models\Item;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class owner_item
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
    //    dd($request->route('id'));

    if( Item::where('id', $request->route('id'))->first() == null) 
    {
        return response()->json([
            'status' => '0',
            'details' => 'item not found'
        ]);

    } //...



        if( Item::where('id', $request->route('id') )->where('user_id' , Auth::id())->first() ==null) //...
        {  
            return response()->json([
                'status' => '0',
                'details' => 'access denied'
            ]);
        }   
        

        return $next($request);
    }
}
