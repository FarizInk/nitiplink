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
Route::get('/profile', fn () => inertia('Welcome'))->name('landing');
Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Core\UserController::class, 'basicProfilePage'])->name('basic');
    Route::post('/', [\App\Http\Controllers\Core\UserController::class, 'updateBasic'])->name('basic.action');
    Route::get('/change-email', [\App\Http\Controllers\Core\UserController::class, 'changeEmailPage'])->name('change-email');
    Route::post('/change-email', [\App\Http\Controllers\Core\UserController::class, 'updateEmail'])->name('change-email.action');
    Route::get('/change-password', [\App\Http\Controllers\Core\UserController::class, 'changePasswordPage'])->name('change-password');
    Route::post('/change-password', [\App\Http\Controllers\Core\UserController::class, 'updatePassword'])->name('change-password.action');
    Route::get('/bind', [\App\Http\Controllers\Core\UserController::class, 'bindProfilePage'])->name('bind');
    Route::post('/bind/token', [\App\Http\Controllers\Core\UserController::class, 'generateToken'])->name('bind.token');
    Route::post('/bind/unbind', [\App\Http\Controllers\Core\UserController::class, 'unbind'])->name('bind.unbind');
});
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

        Route::name('follower.')->prefix('{community}/follower')->group(function () {
            Route::post('/update', [\App\Http\Controllers\Core\FollowerController::class, 'update'])->name('update');
        });

        Route::name('webhook.')->prefix('{community}/webhook')->group(function () {
            Route::post('/', [\App\Http\Controllers\Core\WebhookController::class, 'create'])->name('create');
            Route::delete('/{webhook}', [\App\Http\Controllers\Core\WebhookController::class, 'delete'])->name('delete');
        });
    });
});

Route::middleware('app.community')->name('app.community.')->prefix('/{prefix}')->group(function () {
    Route::get('/', [\App\Http\Controllers\Core\CommunityController::class, 'indexPage'])->name('index');

    Route::name('setting.')->prefix('setting')->middleware('auth')->group(function () {
        Route::get('/', [\App\Http\Controllers\Core\SettingController::class, 'indexPage'])->name('index');
        Route::get('/overview', [\App\Http\Controllers\Core\SettingController::class, 'overviewPage'])->name('overview');
        Route::get('/follower', [\App\Http\Controllers\Core\SettingController::class, 'followerPage'])->name('follower');
        Route::get('/webhook', [\App\Http\Controllers\Core\SettingController::class, 'webhookPage'])->name('webhook');
    });

    Route::get('/{link}', [\App\Http\Controllers\Core\LinkController::class, 'detailPage'])->name('link');
});
