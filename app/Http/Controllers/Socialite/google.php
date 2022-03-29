<?php

namespace App\Http\Controllers\Socialite;
use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Git;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class google extends Controller
{ 
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        dd($googleUser);
        
        // dd($googleUser->token);
        $name= explode(" ",$googleUser->getName());
       
        if (!$name[1])
        $a='a';
        $user = User::create(
            
            [
                'first_name' =>$name[0],

                'last_name' =>$name[1],
                'img' => $googleUser->getAvatar(),
                'email' => $googleUser->getEmail(),
                ]
            );
            // $user = Auth::user();
            $success['token'] = $user->createToken('a')->accessToken;

        //    dd('User successfully login'.'                        '.'token'.'   =>    '.$success['token'].'                                                                                                                     '. $user  );
            return response()->json([
                'msg'=> 'User successfully login',
                 'token'=>$success,
                 'user' => $user
             ], 201);
    
    
    }


    function requestTokenGoogle(Request $request){
        // dd();
        // Getting the user from socialite using token from google
        $user = Socialite::driver('google')->stateless()->userFromToken($request->token);
        if (!$user)
        {
            return response()->json('You do not have access to this email ',402);
        }
        $name= explode(" ",$user->name);

        $userFromDb = User::create(
            [
                'email' => $user->email,
                'first_name'=>$name[0],
                'last_name'=>$name[1],
                'img'=>$user->avatar,

                // 'email_verified_at'=>date("Y-m-d h-i-s"),
                // 'confirmed_at'=>date("Y-m-d h-i-s"),
                // 'email_verified'=>true,
                // 'confirmation_code'=>rand(1,1000),
            ]);
        $userFromDb->email_verified_at=date("Y-m-d h-i-s");
        $userFromDb->confirmed_at    =date("Y-m-d h-i-s");
        $userFromDb->email_verified  =true;
        $userFromDb->confirmation_code  =rand(1, 1000);
        $userFromDb->save();
  
        $success['token'] = $userFromDb->createToken('AyhamAseelAmgadNour')->accessToken;

         return response()->json([
        'msg' => 'User successfully registered',
        'token' => $success,
        'user' => $userFromDb
        ], 201);}
}