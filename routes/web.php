<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\SettingUserController;
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

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('authenticate', [AuthController::class, 'authenticate'])->name('auth.authenticate');
Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('register', [AuthController::class, 'register'])->name('auth.register');
Route::post('register', [AuthController::class, 'doRegister'])->name('auth.doRegister');
Route::get('account/verify/{token}', [AuthController::class, 'verifyAccount'])->name('auth.verify');

Route::get('forgotpassword', [AuthController::class, 'forgotpassword'])->name('auth.forgotpassword');
Route::post('forgotpassword', [AuthController::class, 'sendEmailForgotPassword'])->name('auth.sendForgotPassword');
Route::get('account/resetpassword/{token}', [AuthController::class, 'resetpassword'])->name('auth.resetpassword');
Route::post('resetpassword', [AuthController::class, 'doResetPassword'])->name('auth.doResetPassword');

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('root');

    Route::get('admin/settingusers', [SettingUserController::class, 'index'])->name('admin.settinguser');
    
    Route::middleware(['role:admin'])->group(function () {});
});