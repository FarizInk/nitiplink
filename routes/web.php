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

Route::get('/', function () {
    return inertia('Welcome');
})->name('landing');

Route::post('/login', [\App\Http\Controllers\Core\AuthController::class, 'login'])->name('login');
Route::post('/register', [\App\Http\Controllers\Core\AuthController::class, 'register'])->name('register');
Route::get('/logout', [\App\Http\Controllers\Core\AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->prefix('api/private')->group(function () {
    Route::get('/user', [\App\Http\Controllers\Core\UserController::class, 'getUser']);
});
