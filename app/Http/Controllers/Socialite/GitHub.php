<?php

namespace App\Http\Controllers\Socialite;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Git;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class GitHub extends Controller
{

    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

  
    public function handleProviderCallback()
    {
        $githubUser = Socialite::driver('github')->user();
        if($githubUser->getEmail() ==null)
        {
            $email=$githubUser->getName().'.test.1@gmail.com';
        }
        else 
        {
            $email =$githubUser->getEmail();
        }
        // dd($githubUser->token);
        $user = User::create(
            
            [
                'first_name' => $githubUser->getName(),
                'last_name' =>'',
                'img' => $githubUser->getAvatar(),
                'email' => $email,
                ]
            );
            
            // $user = Auth::user();
            $success['token'] = $user->createToken('a')->accessToken;
            
            
           dd('User successfully login'.'                        '.'token'.'   =>    '.$success['token'].'                                                                                                                     '. $user  );
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
//             'id'    =>$githubUser->token,
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

        // $user = User::where('provider_id', $githubUser->getId())->first();

            // // Create a new user in our database
            // if (! $user) {
            //     $user = User::create([
            //         'email' => $githubUser->getEmail(),
            //         'name' => $githubUser->getName(),
            //         'provider_id' => $githubUser->getId(),
            //     ]);
            // }

        // Log the user in
        // auth()->login($user);

        // Redirect to dashboard