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
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/restock', [InventoryController::class, 'restock'])->name('inventory.restock');
    Route::post('/inventory/restock', [InventoryController::class, 'storeRestock'])->name('inventory.storeRestock');
    Route::get('/inventory/{id}/edit-price', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::patch('/inventory/{id}/price', [InventoryController::class, 'updatePrice'])->name('inventory.updatePrice');
    Route::get('/inventory/{id}/adjust-stock', [InventoryController::class, 'adjustStock'])->name('inventory.adjustStock');
    Route::patch('/inventory/{id}/adjust-stock', [InventoryController::class, 'storeAdjustStock'])->name('inventory.storeAdjustStock');
    # --- End Inventory Section --- #
});