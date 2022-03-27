<?php

use App\Http\Controllers\Socialite\FaceBook;
use App\Http\Controllers\Socialite\GitHub;
use App\Http\Controllers\Socialite\google;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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