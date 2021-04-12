<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SocialAuthController;

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
    return view('rates');
})->name('home');

Route::redirect('/home', '/');

Route::get('/disclaimer', function () {
    return view('disclaimer');
})->name('disclaimer');

Route::get('/support-us', function () {
    return view('support');
})->name('support-us');


Route::get('/test', function () {
    return view('welcome');
});

Route::get('login/{provider}', [SocialAuthController::class, 'redirect'])
    ->name('login-provider');

Route::get('login/{provider}/callback',[SocialAuthController::class, 'callback']);

Route::get('login',[SocialAuthController::class, 'landing'])
    ->name('login');

Route::get('logout',[SocialAuthController::class, 'logout'])
    ->name('logout');

