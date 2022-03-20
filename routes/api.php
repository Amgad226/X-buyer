<?php
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;

use App\Http\Controllers\API\AuthApiController;
use App\Http\Controllers\API\ForgetAndRestPass;
use App\Http\Controllers\API\ItemController;
use App\Http\Controllers\API\VerificationController ;
// use App\Http\Controllers\API\VerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



// 


Route::post('/register' ,[AuthApiController::class, 'register'      ]);///
  Route::post('/login',  [AuthApiController::class, 'login'         ])   ;

  
  Route::post('/forgot_password', [ForgetAndRestPass::class,                'forgot']);
  Route::post('/reset_password',  [ForgetAndRestPass::class,                'reset']);


  
  
  Route::post('/send_verifay',    [VerificationController::class,              'send_verify'])->middleware('auth:api');
  Route::post('/confirm_verifay',  [VerificationController::class,             'confirm_verify'])->middleware('auth:api');
  
  
  
  
  
  
  
  
  Route::middleware('auth:api')->group( function(){
Route::get('/get_Categories',                      [ItemController   ::class, 'get_Categories']);//->middleware(['auth','verified']);
});



// Route::get('/ssss', function () {
  // return response()->json(['msg' => 'OK']) ;}) ->name('verification.notice') ;
// Auth::routes(['verify' => true]);

    Route::get('/verified-middleware-example', [VerificationController::class, 'resend'         ])   ;
    Route::get('/verified-middleware-example2', [VerificationController::class, 'verify'         ])   ;
    // return response()->json(['msg' => 'the account is already confirmed  now']) ;
// })->middleware('auth:api','verified');
  //
  
  Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
  Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');

  
/*_______________________________________________________________________________________________*/
Route::middleware('auth:api')->group( function(){
    Route::post('/logout',                             [AuthApiController::class,'logout'                   ]);
    });




// Route::get('/my_products',                          'myproducts'              );
