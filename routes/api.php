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

Route::put('favorite/{provider}',[FavoriteController::class, 'addAll'])
     ->middleware('auth:api')
     ->name('addAllFavorite');

Route::delete('favorite/{provider}',[FavoriteController::class, 'deleteAll'])
     ->middleware('auth:api')
     ->name('deleteAllFavorite');

Route::put('alert/{provider}/{coin}',[AlertController::class, 'addAlert'])
     ->middleware('auth:api')
     ->name('addAlert');

Route::delete('alert/{provider}/{coin}',[AlertController::class, 'deleteAlert'])
     ->middleware('auth:api')
     ->name('deleteAlert');

Route::put('alert/{provider}',[AlertController::class, 'addAll'])
     ->middleware('auth:api')
     ->name('addAllAlert');

Route::delete('alert/{provider}',[AlertController::class, 'deleteAll'])
     ->middleware('auth:api')
     ->name('deleteAllAlert');

Route::delete('/unsubscribe/{emailId}', [UnsubscribeController::class, 'processUnsubscribe'])
     ->name('unsubscribe-process');
