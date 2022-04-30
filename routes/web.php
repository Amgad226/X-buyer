<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ItemController;
use App\Http\Controllers\Curl;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\qr;
use App\Http\Controllers\Socialite\FaceBook;
use App\Http\Controllers\Socialite\GitHub;
use App\Http\Controllers\Socialite\google;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

// use SimpleSoftwareIO\QrCode\Facades\QrCode;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', fn () => phpinfo());


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/redirect/{service}', 'SocialController@redirect');

Route::get('/callback/{service}', 'SocialController@callback');


Route::get('login/github', [GitHub::class, 'redirectToProvider']);
Route::get('login/github/callback', [GitHub::class, 'handleProviderCallback']);

Route::get('login/facebook', [FaceBook::class, 'redirectToProvider']);
Route::get('login/facebook/callback', [FaceBook::class, 'handleProviderCallback']);


Route::get('login/google', [google::class, 'redirectToProvider']);
Route::get('login/google/callback', [google::class, 'handleProviderCallback']);


Route::get('log', [Curl::class, 'Curl']);
Route::get ('/offer',            [ItemController::class,  'offer'           ] );      
Route::get('qr', function () {
  
    // QrCode::size(500)
    //         ->format('png')
    //         ->generate('ItSolutionStuff.com', public_path('images/qrcode.png'));
    
  return view('qrCode');});

  Route::get('ss/{id}', [qr::class,  'index'           ] );    

  Route::get('/qr-info', function () {
    return view("currency");    
});
  