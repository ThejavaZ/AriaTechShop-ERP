<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/auth/login',[AuthController::class, 'login'])->name('login');
Route::post('/auth/store',[AuthController::class, 'store'])->name('auth.store');
Route::post('/auth/logout',[AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function(){

    # --- Home Section --- #
    Route::get('/',[HomeController::class, 'home'])->name('home');
    # --- End Home Section --- #

    # --- User Section --- #
    Route::get('/users',[UserController::class, 'index'])->name('users');
    # --- End User Section --- #
});