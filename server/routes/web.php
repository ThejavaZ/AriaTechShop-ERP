<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Repairs\RepairsList;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleDetailController;

Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/store', [AuthController::class, 'store'])->name('auth.store');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    # --- Home Section --- #
    Route::get('/', [HomeController::class, 'home'])->name('home');
    # --- End Home Section --- #

    # --- User Section --- #
    Route::get('/users', [UserController::class, 'index'])->name('users');

    Route::get('/users-chart-data', [UserController::class, 'usersChart'])
    ->name('users.chart.data');
    # --- End User Section --- #

    # --- Inventory Section --- #
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/restock', [InventoryController::class, 'restock'])->name('inventory.restock');
    Route::post('/inventory/restock', [InventoryController::class, 'storeRestock'])->name('inventory.storeRestock');
    Route::get('/inventory/report', [InventoryController::class, 'report'])->name('inventory.report');
    Route::get('/inventory/report/pdf', [InventoryController::class, 'exportPdf'])->name('inventory.report.pdf');
    Route::get('/inventory/report/excel', [InventoryController::class, 'exportExcel'])->name('inventory.report.excel');
    Route::get('/inventory/report/word', [InventoryController::class, 'exportWord'])->name('inventory.report.word');
    Route::get('/inventory/{id}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    
    #-- Repairs section --#
    Route::get('/repairs', RepairsList::class)->name('repairs.index');

    Route::get('/users/create',[UserController::class, 'create'])->name('users.create');
    Route::get('/users/{id}',[UserController::class, 'show'])->name('users.show');
    # --- End User Section --- #

    # --- Inventory Section --- #
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index')
    ->withoutMiddleware('auth'); //temporal
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create')
    ->withoutMiddleware('auth'); //temporal
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store')
    ->withoutMiddleware('auth'); //temporal
    # --- End Inventory Section --- #

    # --- SALES --- #
    Route::resource('sales', SaleController::class);

    Route::get('/sales-report', [SaleController::class,'report'])
        ->name('sales.report');

    Route::get('/sales-chart', [SaleController::class, 'chartView'])
        ->name('sales.chart');

    Route::get('/sales-chart-data', [SaleController::class, 'salesChart'])
        ->name('sales.chart.data');

    Route::get('/sales-report/excel', [SaleController::class, 'exportExcel'])
    ->name('sales.report.excel');

    # --- SALE DETAILS --- #
    Route::resource('sale_details', SaleDetailController::class);

    Route::get('/sale-details-report', [SaleDetailController::class,'report'])
        ->name('sale_details.report');

    Route::get('/sale-details-report/excel', [SaleDetailController::class, 'exportExcel'])
    ->name('sale_details.report.excel');

});