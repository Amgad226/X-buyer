<?php
namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Mail\welcomeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\WelcomeEmailNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Passport;
use Laravel\Socialite\Facades\Socialite;

class AuthApiController extends Controller
{
    public function register(Request $request)
    {
        // dd($request->first_name);
        $validator = Validator::make($request-> all(),[
            'first_name' => ['required', 'string', 'max:50','min:3'],
            'last_name'  => ['required', 'string', 'max:50','min:3'],
            'email'      => 'required',
            'password'   => ['required', 'string', 'min:4'],
            'c_password' => 'required|same:password',
            'phone'      => 'required',
            'img'        => 'nullable',
        ]);
        if ($validator->fails()){

            return response()->json([
                'error'      => $validator->errors()],400
              );
        }
        
        // اذا مافي صورة بل ريكويست 
        //عبيلي قيم الريكويست ما عدا الصوة بل داتا 
        //ووقت ينبعتو البيانات عل داتابيز لحالها الصورة هنيك بتصير نال
        if($request->img==null){
            $input = [
                'first_name'=> $request->first_name,
                'last_name' => $request->last_name,
                'email'     => $request->email,
                'password'  => $request->password,
                'phone'     => $request->phone,
            ];
        }

        if($request->hasFile('img'))
        { 
            $uniqid='('.uniqid().')';                                 //كل كرة بيعطيني رقم فريد     انا عم استخدمو مشان اسم كل صورة يكون غير التاني حتى لو اسم الصورة والمستخدم  نفسو

            $destination_path = 'public/images/users';                       //storage بمسار الصورة للتخزين جوات ال  
            $request->file('img')->storeAs($destination_path,$uniqid.$request->img->getClientOriginalName());  //بل اسم واللاحقة الصح storage/public/images/users تخزينن الصورة بل
            //هلأ هون نحنا عاملين 
            //php artisan storage:link
            //The [C:\Users\ASUS\Desktop\New folder\X-Buyer old\public\storage] link has been connected to [C:\Users\ASUS\Desktop\New folder\X-Buyer old\storage\app/public].
            //الملفات الموجودة بل ستوريج بروح لحالها بصير بل بابليك ب هاد المسار
            $image_path = "/storage/images/users/" . $uniqid.$request->img->getClientOriginalName();           // مشان نبعتو بل ريسبونس للفلاتر publicباث الصورة يلي بل 
            //هيك الصورة فيك تفتحا ب رابط لوكال هوست متل ال بهب لانو صارت ب ملف البابليك وهيك بدا يوصللها لفلاتر 
            
            $input = [
                'first_name'=> $request->first_name,
                'last_name' => $request->last_name,
                'email'     => $request->email,
                'password'  => $request->password,
                'phone'     => $request->phone,
                'img'       => $image_path,   //هون حطيت باث الصورة يلي بل بابليك مشان يروح الباث عل داتا بيز واسيل تاخد هاد الباث 
          ];
         }
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        
        $success['token'] = $user->createToken('AyhamAseelAmgadNour')->accessToken;
        // event(new Registered($user));
        // $user->notify(new WelcomeEmailNotification());
        // Mail::to($user->email)->send(new ResetMail ($details));
        // dd($input['first_name']);
        // Mail::to($user->email)->send(new welcomeMail($input));ph

        return response()->json([
        'msg' => 'User successfully registered',
        'token' => $success,
        'user' => $user
        ], 201);
    }
    // _________________________________________________________________________________
    public function login(Request $request){ 
        if(Auth::attempt(['email' =>$request->email, 'password' => $request->password]))
        {
            $user = Auth::user();
            
            $success['token'] = $user->createToken('a')->accessToken;

            return response()->json([
               'msg'=> 'User successfully login',
                'token'=>$success,
                'user' => $user
            ], 201);
        }

        else if(Auth::attempt(['first_name' =>$request->first_name, 'password' => $request->password]))
        {
            $user = Auth::user();
            
            $success['token'] = $user->createToken('a')->accessToken;

            return response()->json([
               'msg'=> 'User successfully login',
                'token'=>$success,
                'user' => $user
            ], 201);
        }
        else {
            return response()->json(['error' => 'Wrong email or password'], 401);
        }
    }
    // _________________________________________________________________________________
    public function logout(Request $request) 
    {
      $request->user()->token()->revoke();
      return response()->json(['message' => 'User successfully logged out']);
    }
        // _________________________________________________________________________________
        function requestTokenGoogle(Request $request){
            // dd();
            // Getting the user from socialite using token from google
            $UserFormGoogle = Socialite::driver('google')->stateless()->userFromToken($request->token);
            if (!$UserFormGoogle)
            {
                return response()->json('You do not have access to this email ',402);
            }
            $name= explode(" ",$UserFormGoogle->name);
    
            $UserToDataBase = User::create(
                [
                    'email' => $UserFormGoogle->email,
                    'first_name'=>$name[0],
                    'last_name'=>$name[1],
                    'img'=>$UserFormGoogle->avatar,
    
                    // 'email_verified_at'=>date("Y-m-d h-i-s"),
                    // 'confirmed_at'=>date("Y-m-d h-i-s"),
                    // 'email_verified'=>true,
                    // 'confirmation_code'=>rand(1,1000),
                ]);
            $UserToDataBase->email_verified_at=date("Y-m-d h-i-s");
            $UserToDataBase->confirmed_at    =date("Y-m-d h-i-s");
            $UserToDataBase->email_verified  =true;
            $UserToDataBase->confirmation_code  =rand(1, 1000);
            $UserToDataBase->save();
      
            $success['token'] = $UserToDataBase->createToken('AyhamAseelAmgadNour')->accessToken;
    
             return response()->json([
            'msg' => 'User successfully registered',
            'token' => $success,
            'user' => $UserToDataBase
            ], 201);}
               // _________________________________________________________________________________
        function requestTokenFacebook(Request $request){
            // dd();
            // Getting the user from socialite using token from google
            // $UserFormFacebook = Socialite::driver('facebook')->stateless()->userFromToken($request->token);
             $UserFormFacebook =  Socialite::driver('facebook')->stateless()->userFromToken($request->token);

            
         // dd($UserFormFacebook);
            if (!$UserFormFacebook)
            {
                return response()->json('You do not have access to this email ',402);
            }
            $name= explode(" ",$UserFormFacebook->name);
    
            $UserToDataBase = User::create(
                [
                    'email' => $UserFormFacebook->email,
                    'first_name'=>$name[0],
                    'last_name'=>'d',
                    'img'=>$UserFormFacebook->avatar,
    
                    // 'email_verified_at'=>date("Y-m-d h-i-s"),
                    // 'confirmed_at'=>date("Y-m-d h-i-s"),
                    // 'email_verified'=>true,
                    // 'confirmation_code'=>rand(1,1000),
                ]);
            $UserToDataBase->email_verified_at=date("Y-m-d h-i-s");
            $UserToDataBase->confirmed_at    =date("Y-m-d h-i-s");
            $UserToDataBase->email_verified  =true;
            $UserToDataBase->confirmation_code  =rand(1, 1000);
            $UserToDataBase->save();
      
            $success['token'] = $UserToDataBase->createToken('amgad226')->accessToken;
    
             return response()->json([
            'msg' => 'User successfully registered',
            'token' => $success,
            'user' => $UserToDataBase
            ], 201);}
}
