<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
 use App\Livewire\Repairs\RepairsList;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SaleController;

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

    #-- Repairs section --#
    Route::get('/repairs', RepairsList::class)->name('repairs.index');



    
    # --- End Inventory Section --- #

    #-- sales section --#

Route::resource('sales', SaleController::class);
Route::get('/sales-chart-data', [SaleController::class, 'salesChart'])
    ->name('sales.chart.data');
Route::get('/sales-chart', [SaleController::class, 'chartView'])->name('sales.chart');
Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
Route::get('/sales', [SaleController::class, 'index']);
});



