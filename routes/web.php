<?php

use App\Http\Controllers\Auth\AuthController;
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
    return view('welcome');
})->middleware('auth');
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('authenticate', [AuthController::class, 'authenticate'])->name('auth.authenticate');
Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('register', [AuthController::class, 'register'])->name('auth.register');
Route::get('forgotpassword', [AuthController::class, 'forgotpassword'])->name('auth.forgotpassword');
