<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use AmrShawky\LaravelCurrency\Facade\Currency;

class Currencyy extends Controller
{
    public function transport(Request $request)
    {
   
       $a= Currency::convert()
        ->from($request->from)
        ->to($request->to)
        ->amount($request->amount)
        ->get();


        return response()->json($a);
    } 
}
