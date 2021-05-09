<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\RatesController;
use App\Http\Controllers\UnsubscribeController;
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

Route::put('alert/{provider}/{coin}',[AlertController::class, 'addAlert'])
     ->middleware('auth:api')
     ->name('addAlert');

Route::delete('alert/{provider}/{coin}',[AlertController::class, 'deleteAlert'])
     ->middleware('auth:api')
     ->name('deleteAlert');

Route::delete('/unsubscribe/{emailId}', [UnsubscribeController::class, 'processUnsubscribe'])
     ->name('unsubscribe-process');
