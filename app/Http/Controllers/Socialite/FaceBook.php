<?php

namespace App\Http\Controllers\Socialite;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Git;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class FaceBook extends Controller
{

    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

  
    public function handleProviderCallback()
    {
        $FacebookUser = Socialite::driver('facebook')->user();
        if($FacebookUser->getEmail() ==null)
        {
            $email=$FacebookUser->getName().'.test.1@gmail.com';
        }
        else 
        {
            $email =$FacebookUser->getEmail();
        }
        // dd($FacebookUser->token);
        $user = User::create(
            
            [
                'first_name' => $FacebookUser->getName(),
                'last_name' =>'',
                'img' => $FacebookUser->getAvatar(),
                'email' => $email,
                ]
            );
            
            // $user = Auth::user();
            $success['token'] = $user->createToken('a')->accessToken;
            
            
           
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
//             'id'    =>$FacebookUser->token,
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

        // $user = User::where('provider_id', $FacebookUser->getId())->first();

            // // Create a new user in our database
            // if (! $user) {
            //     $user = User::create([
            //         'email' => $FacebookUser->getEmail(),
            //         'name' => $FacebookUser->getName(),
            //         'provider_id' => $FacebookUser->getId(),
            //     ]);
            // }

        // Log the user in
        // auth()->login($user);

        // Redirect to dashboard