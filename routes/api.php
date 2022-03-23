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
use Laravel\Socialite\Facades\Socialite;
// use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Facades\Socialite as  sss;
/*==============================================================================================================================*/
/*==============================================================================================================================*/
/*==============================================================================================================================*/

Route::get('/auth/redirect', function () {
  return Socialite::driver('github')->redirect();
});

Route::get('/auth/callback', function () {
  $user = Socialite::driver('github')->user();

  // $user->token
});

Route::middleware('auth:api')->group( function(){
Route::get('/get_Categories',                      [ItemController   ::class, 'get_Categories']);//->middleware(['auth','verified']);
});

Route::get('/ssss', function () {
return response()->json(['msg' => 'OK']) ;}) ->name('verification.notice') ;
// Auth::routes(['verify' => true]);

  // Route::get('/verified-middleware-example', [VerificationController::class, 'resend'         ])   ;
  // Route::get('/verified-middleware-example2', [VerificationController::class, 'verify'         ])   ;
  // return response()->json(['msg' => 'the account is already confirmed  now']) ;
// })->middleware('auth:api','verified');
Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');


/*==============================================================================================================================*/
/*==============================================================================================================================*/
/*==============================================================================================================================*/

  Route::post('/register' ,[AuthApiController::class, 'register'      ]);
  Route::post('/login',    [AuthApiController::class, 'login'         ])   ;
/*_______________________________________________________________________________________________*/
Route::middleware('auth:api')->group( function(){
  Route::post('/logout',                             [AuthApiController::class,'logout'                   ]);
  /*_____________________________________________________________________________________________________*/
  Route::post('/forgot_password',                    [ForgetAndRestPass::class,        'forgot']);//->middleware('verifay') ;
  Route::post('/reset_password',                     [ForgetAndRestPass::class,        'reset']);
  /*_____________________________________________________________________________________________________*/
  Route::post('/send_verifay',                       [VerificationController::class,   'send_verify'   ] );
  Route::post('/confirm_verifay',                    [VerificationController::class,   'confirm_verify'] );
  /*_____________________________________________________________________________________________________*/
  Route::post('/add_Item',                           [ItemController::class, 'addItem'                 ] );
  Route::post('/update_item/{id}',                   [ItemController::class, 'updateitem'              ] )->middleware('owner_item');
  Route::post('/delete_Item/{id}',                   [ItemController::class, 'deleteItem'              ] )->middleware('owner_item');
  Route::post('/Discount_Items_And_Show',            [ItemController::class, 'discount_items_And_Show' ] );
  Route::get('/my_products',                         [ItemController::class,  'myproducts'             ] );
  /*___________________________________________________________________________________________________]__*/
  Route::get('/Sort_ASC',                            [ItemController::class, 'Sort_ASC'                ] );
  Route::get('/Sort_DESC',                           [ItemController::class, 'Sort_DESC'               ] );
  Route::get('/search_By_Name/{name}',               [ItemController::class, 'searchByName'            ] );
  Route::get('/search_By_Cat/{searchByCATE}',        [ItemController::class, 'searchByCATE'            ] );
  Route::get('/search_By_Expir_date/{expir_date}',   [ItemController::class, 'search_Expir_Date'       ] );
  /*___________________________________________________________________________________________________]__*/
  Route::get ('/Add_View/{item_id}',                 [ItemController::class,  'Add_View'               ] );
  Route::get ('/AddLike/{item_id}',                  [ItemController::class,  'AddLike'                ] );
  Route::get ('/UnLike/{item_id}',                   [ItemController::class,  'UnLike'                 ] );
  Route::get ('/Get_Items_Liked',                    [ItemController::class,  'Get_Items_Liked'        ] );
  Route::post('/add_Comment/{item_id}',              [ItemController::class,  'addComment'             ] );
  Route::post('/remove_Comment/{comm_id}',           [ItemController::class,  'removeComment'          ] );
  Route::get ('/Show_Comments/{item_id}',            [ItemController::class,  'ShowComments'           ] );      
});

