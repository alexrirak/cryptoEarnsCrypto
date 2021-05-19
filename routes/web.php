<?php

use App\Http\Controllers\RatesController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\UnsubscribeController;
use App\Http\Controllers\UserController;
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

Route::redirect('/', '/rates/celsius')->name('home');

Route::redirect('/home', '/');

Route::get('/rates/{provider}', [RatesController::class, 'showRatesView'])
    ->name('rates');

Route::get('/disclaimer', function () {
    return view('disclaimer');
})->name('disclaimer');

Route::get('/support-us', function () {
    return view('support');
})->name('support-us');

Route::get('/privacy-center', function () {
    return view('common.privacy');
})->name('privacy-center');

Route::redirect('/cookie-policy', '/privacy-center#cookie-policy')->name('cookie-policy');

Route::get('/unsubscribe/{emailId}', [UnsubscribeController::class, 'showUnsubscribePage'])
     ->name('unsubscribe');

Route::get('login/{provider}', [SocialAuthController::class, 'redirect'])
     ->name('login-provider');

Route::get('login/{provider}/callback', [SocialAuthController::class, 'callback']);

Route::get('login', [SocialAuthController::class, 'landing'])
     ->name('login');

Route::get('logout', [SocialAuthController::class, 'logout'])
     ->name('logout');

Route::get('/profile', [UserController::class, 'showProfile'])
     ->middleware('auth')
     ->name('profile');

Route::get('/delete-user', [UserController::class, 'deleteUser'])
     ->middleware('auth')
     ->name('delete-user');

Route::get('/subscriptions', [UserController::class, 'showSubscriptions'])
     ->middleware('auth')
     ->name('subscriptions');

