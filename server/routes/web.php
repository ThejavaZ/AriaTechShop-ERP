<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/',[HomeController::class, 'home'])->name('home');

Route::get('/users',[UserController::class, 'index'])->name('users');