<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\demomail;
use App\Mail\ResetMail;
use App\Models\User;
use App\Notifications\WelcomeEmailNotification;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgetAndRestPass extends Controller
{
    public function forgot(Request $re)
    {
        $email = $re->input('email');
        $user=User::where('email',$email)->first();
        if($user==null)
        return response(['mes'=>'user not exist',404  ]);

        $token = Str::random(10);

        $details=[
            'title'=>'mail',
            'body'=>$token
        ];
        Mail::to($user->email)->send(new ResetMail ($details));



        // dd($user->email);
        // $user->notify(new WelcomeEmailNotification());
        try 
            {
                DB::table('password_resets')->insert(['email'=>$email,'token'=>$token]);
                return response(['Message'=>'check your email']);
            }  

        catch(\Exception $e) 
            {
                return response(['Message'=>$e->getMessage()]);
            }
    }

    public function reset(Request $re)
    {
        // dd('dsa');
        $token = $re->input('token');
        $passwordReset = DB::table('password_resets')->where('token',$token)->first();
        if( $passwordReset  ==null)
        {
            return response(["mas"=>'invalide token',403]);
        }+         $user=User::where('email',$passwordReset->email)->first();
        if($user==null)
        {
            return response(['message '=>'user dosent exist',404]);
        }
        $user->password=($re->input('password'));
        $user->save();
        // DB::table('password_resets')->where('token',$token)->first()->delete();
        DB::table('password_resets')->where('token', $token)->delete();
        // DB::table('password_resets')->DELETE(['token'=>$token]);
        return response(['mes'=>'success']);
    }

}


