<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;

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

    # --- Inventory Section --- #
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index')
    ->withoutMiddleware('auth'); //temporal
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create')
    ->withoutMiddleware('auth'); //temporal
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store')
    ->withoutMiddleware('auth'); //temporal
    
    # --- End Inventory Section --- #
});