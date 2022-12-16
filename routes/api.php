<?php

use Illuminate\Http\Request;
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

Route::middleware('bot')->prefix('bot')->group(function () {
    Route::post('/check', [\App\Http\Controllers\Api\BotController::class, 'check']);
    Route::post('/bind-account', [\App\Http\Controllers\Api\BotController::class, 'bindAccount']);
    Route::post('/create-link', [\App\Http\Controllers\Api\BotController::class, 'createLink']);
});
