<?php

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

Route::get('/', fn () => inertia('Welcome'))->name('landing');
Route::post('/login', [\App\Http\Controllers\Core\AuthController::class, 'login'])->name('login');
Route::post('/register', [\App\Http\Controllers\Core\AuthController::class, 'register'])->name('register');
Route::post('/logout', [\App\Http\Controllers\Core\AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->prefix('api/private')->group(function () {
    Route::get('/user', [\App\Http\Controllers\Core\UserController::class, 'data']);

    Route::get('/communities', [\App\Http\Controllers\Core\CommunityController::class, 'get'])->name('community.get');
    Route::name('community.')->prefix('community')->group(function () {
        Route::post('/', [\App\Http\Controllers\Core\CommunityController::class, 'create'])->name('create');
        Route::put('/{community}', [\App\Http\Controllers\Core\CommunityController::class, 'update'])->name('update');
        Route::delete('/{community}', [\App\Http\Controllers\Core\CommunityController::class, 'delete'])->name('delete');
        Route::post('/{community}/follow', [\App\Http\Controllers\Core\CommunityController::class, 'follow'])->name('follow');
        Route::post('/{community}/unfollow', [\App\Http\Controllers\Core\CommunityController::class, 'unfollow'])->name('unfollow');

        Route::name('link.')->prefix('{community}/link')->group(function () {
            Route::post('/', [\App\Http\Controllers\Core\LinkController::class, 'create'])->name('create');
            Route::put('/{link}', [\App\Http\Controllers\Core\LinkController::class, 'update'])->name('update');
            Route::delete('/{link}', [\App\Http\Controllers\Core\LinkController::class, 'delete'])->name('delete');
        });

        Route::get('/{community}/followers', [\App\Http\Controllers\Core\FollowerController::class, 'get'])->name('follower.get');
        Route::name('follower.')->prefix('{community}/follower')->group(function () {
            Route::post('/update', [\App\Http\Controllers\Core\FollowerController::class, 'update'])->name('update');
        });

        Route::get('/{community}/webhooks', [\App\Http\Controllers\Core\WebhookController::class, 'get'])->name('webhook.get');
        Route::name('webhook.')->prefix('{community}/webhook')->group(function () {
            Route::post('/', [\App\Http\Controllers\Core\WebhookController::class, 'create'])->name('create');
            Route::delete('/{webhook}', [\App\Http\Controllers\Core\WebhookController::class, 'delete'])->name('delete');
        });
    });
});

Route::middleware('app.community')->prefix('/{prefix}')->group(function () {
    Route::get('/', [\App\Http\Controllers\Core\CommunityController::class, 'indexPage'])->name('app.community');
    Route::get('/{link}', [\App\Http\Controllers\Core\LinkController::class, 'detailPage'])->name('app.community.link.detail');
    Route::name('setting.')->prefix('setting')->group(function () {
        Route::get('/', [\App\Http\Controllers\Core\SettingController::class, 'get'])->name('get');
    });
});
