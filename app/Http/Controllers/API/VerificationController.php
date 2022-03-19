<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\ResetMail;
use App\Mail\verifyEmail;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class VerificationController extends Controller
{
    public function send_verify(Request $request)
    {
        $email = $request->input('email');
        $user=User::where('email',$email)->first();

        if($user==null)
        return response()->json(['mes'=>'user not exist',404  ]);


        // if ($user->email_verified==1)
        // return response()->json([   'message'=>'this email is already confirmed'   ]);
        
        $token = rand(1, 1000);

        $details=[
            // 'title'=>'mail',
            'body'=>$token
        ];
        Mail::to($user->email)->send(new verifyEmail ($details));

        try 
            {
                DB::table('users')->where('email',Auth::user()->email)->update(['confirmation_code'=>$token,'email_verified_at'=>1]);
                return response()->json(['Message'=>'check your email']);
            }  

        catch(\Exception $e) 
            {
                return response()->json(['Message'=>$e->getMessage(),404]);
            }
    }

    // 'email_verified'=>true,
    
    public function confirm_verify(Request $request)
    {
       
        $r= DB::table('users')->where('email',Auth::user()->email)->first();
         if($r->email_verified==1)
        return response()->json([
            'message'=>'this email is already confirmed'
        ]);
        
        $token = $request->input('token');
        // $user_to_verifay = DB::table('users')->where('confirmation_code',$token)->first();
        if(!  DB::table('users')->where('email',Auth::user()->email)->where('confirmation_code',$token)->first() )
        {
            return response()->json(["mas"=>'invalide token',403]);
        }

        // dd('dd');
       DB::table('users')->where('email',Auth::user()->email)->update(['email_verified'=>true,'confirmed_at'=>date("Y-m-d h-i-s")]);

        return response()->json(['mes'=>'success']);
    }

}


