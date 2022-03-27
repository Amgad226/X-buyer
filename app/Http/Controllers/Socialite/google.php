<?php

namespace App\Http\Controllers\Socialite;

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
        // dd($googleUser);
        
        // dd($googleUser->token);
        $name= explode(" ",$googleUser->getName());
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
}


 // dd(1);
            // dd($user);
//         $r =Git::where('user_id',3)->first();
//         DB::table('oauth_access_tokens')->insert([  
//             'id'    =>$googleUser->token,
//       'user_id'=>$user->id,
//       'client_id'=>1,
//       'name'=>'a',
//       'scopes'=>'[]',
//       'revoked'=>0, 
//   ]);
        // $data = [
        //          'id'    =>1,
        //         //  'id'    =>$user->token,
        //         'user_id'=>$user->id,
        //         'client_id'=>2,
        //         'name'=>'a',
        //         'scope'=>'[]',
        //         'revoked'=>0,   
        // ];
    
        // $r->update($data);
        
            // dd($user->id . $user->id) ;

        // $user = User::where('provider_id', $googleUser->getId())->first();

            // // Create a new user in our database
            // if (! $user) {
            //     $user = User::create([
            //         'email' => $googleUser->getEmail(),
            //         'name' => $googleUser->getName(),
            //         'provider_id' => $googleUser->getId(),
            //     ]);
            // }

        // Log the user in
        // auth()->login($user);

        // Redirect to dashboard