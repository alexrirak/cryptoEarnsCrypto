<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RatesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/rate-stats', [RatesController::class, 'getAllRates'])
     ->name('rate-stats');

Route::get('/rate-stats/{source}',[RatesController::class, 'getRates'])
     ->name('getRates');

Route::put('favorite/{provider}/{coin}',[FavoriteController::class, 'addFavorite'])
    ->middleware('auth:api')
    ->name('addFavorite');

Route::delete('favorite/{provider}/{coin}',[FavoriteController::class, 'deleteFavorite'])
     ->middleware('auth:api')
     ->name('deleteFavorite');

Route::put('notification/{provider}/{coin}',[NotificationController::class, 'addNotification'])
     ->middleware('auth:api')
     ->name('addNotification');

Route::delete('notification/{provider}/{coin}',[NotificationController::class, 'deleteNotification'])
     ->middleware('auth:api')
     ->name('deleteNotification');
