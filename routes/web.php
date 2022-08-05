<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CelsiusTrackerMigrationController;
use App\Http\Controllers\EmailAuthController;
use App\Http\Controllers\HistoryController;
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

Route::redirect('/', '/rates/gemini')->name('home');

Route::redirect('/home', '/');

Route::get('/rates/{provider}', [RatesController::class, 'showRatesView'])
     ->name('rates');

Route::get('/history/{provider}/{coin}', [HistoryController::class, 'showHistoryByProviderAndCoinView'])
     ->name('history-by-provider-and-coin');

Route::get('/disclaimer', function () {
    return view('disclaimer');
})->name('disclaimer');

Route::get('/support-us', function () {
    return view('common.support');
})->name('support-us');

Route::get('/privacy-center', function () {
    return view('common.privacy');
})->name('privacy-center');

Route::redirect('/cookie-policy', '/privacy-center#cookie-policy')->name('cookie-policy');

Route::get('/unsubscribe/{emailId}', [UnsubscribeController::class, 'showUnsubscribePage'])
     ->name('unsubscribe');

Route::get('login/{provider}', [SocialAuthController::class, 'redirect'])
     ->name('login-provider');

Route::get('login/{provider}/callback', [SocialAuthController::class, 'callback'])
     ->middleware('guest');

Route::get('signin', [SocialAuthController::class, 'signin'])
     ->middleware('guest')
     ->name('signin');

Route::get('signup', [SocialAuthController::class, 'signup'])
     ->middleware('guest')
     ->name('signup');

Route::redirect('/login', '/signin')
     ->name('login');

Route::get('email-login', [EmailAuthController::class, 'landing'])
     ->middleware('guest')
     ->name('email-login-landing');

Route::post('email-login', [EmailAuthController::class, 'login'])
     ->middleware('guest')
     ->name('email-login');

Route::get('verify-login/{token}', [EmailAuthController::class, 'verifyLogin'])
     ->middleware('guest')
     ->name('verify-login');

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

Route::get('/admin', [AdminController::class, 'showUserStatView'])
     ->middleware('auth')
     ->middleware('isAdmin')
     ->name('admin-dashboard');

// Celsius tracker Migration
Route::get('celsiusTracker', [CelsiusTrackerMigrationController::class, 'landing'])
     ->middleware('guest')
     ->name('celsiusTrackerMigration-landing');

Route::get('celsiusTracker/{emailId}', [CelsiusTrackerMigrationController::class, 'migrateView'])
     ->middleware('guest')
     ->name('celsiusTrackerMigration-migrate');
