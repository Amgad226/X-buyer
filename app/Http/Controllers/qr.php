<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class qr extends Controller
{
     function index($id){
          $user = User::where('id',$id)->first(); 
          // dd($user->first_name);
          return view('currency',['user'=>$user]);
    

          

     }
}
