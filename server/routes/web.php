<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Repairs\RepairsList;
use App\Http\Controllers\InventoryController;

Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/store', [AuthController::class, 'store'])->name('auth.store');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    # --- Home Section --- #
    Route::get('/', [HomeController::class, 'home'])->name('home');
    # --- End Home Section --- #

    # --- User Section --- #
    Route::get('/users', [UserController::class, 'index'])->name('users');
    # --- End User Section --- #

    # --- Inventory Section --- #
    Route::get('/inventory', [InventoryController::class, 'index'])
        ->middleware('can:inventory.view')
        ->name('inventory.index');
    Route::get('/inventory/create', [InventoryController::class, 'create'])
        ->middleware('can:inventory.create')
        ->name('inventory.create');
    Route::post('/inventory', [InventoryController::class, 'store'])
        ->middleware('can:inventory.create')
        ->name('inventory.store');
    Route::get('/inventory/{id}/edit', [InventoryController::class, 'edit'])
        ->middleware('can:inventory.update')
        ->name('inventory.edit');
    Route::put('/inventory/{id}', [InventoryController::class, 'update'])
        ->middleware('can:inventory.update')
        ->name('inventory.update');
    Route::get('/inventory/restock', [InventoryController::class, 'restock'])
        ->middleware('can:inventory.restock')
        ->name('inventory.restock');
    Route::post('/inventory/restock', [InventoryController::class, 'storeRestock'])
        ->middleware('can:inventory.restock')
        ->name('inventory.storeRestock');

    #-- Repairs section --#
    Route::get('/repairs', RepairsList::class)->name('repairs.index');




    # --- End Inventory Section --- #
});
