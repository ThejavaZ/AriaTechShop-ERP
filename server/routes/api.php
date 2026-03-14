<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Importación de Controladores (Asegurando PascalCase 'Api' según tus carpetas)
use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\Api\UserController as ApiUserController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\InventoryController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::post('/auth/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes (Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // --- Autenticación y Perfil ---
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', function (Request $request) {
        return response()->json([
            'user'        => $request->user(),
            'roles'       => $request->user()->getRoleNames(),
            'permissions' => $request->user()->getAllPermissions()->pluck('name'),
        ]);
    });

    // --- Users (Solo administradores) ---
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('users', ApiUserController::class);
    });

    // --- Sales (Ventas) ---
    Route::prefix('sales')->group(function () {
        Route::get('/',         [SaleController::class, 'index'])  ->middleware('can:sales.view');
        Route::get('/{id}',     [SaleController::class, 'show'])   ->middleware('can:sales.view');
        Route::post('/',        [SaleController::class, 'store'])  ->middleware('can:sales.create');
        Route::delete('/{id}',  [SaleController::class, 'destroy'])->middleware('can:sales.delete');
    });

    // --- Repairs (Reparaciones) ---
    Route::prefix('repairs')->group(function () {
        Route::get('/',                    [RepairController::class, 'index'])         ->middleware('can:repairs.view');
        Route::post('/',                   [RepairController::class, 'store'])         ->middleware('can:repairs.create');
        Route::get('/{id}',                [RepairController::class, 'show'])          ->middleware('can:repairs.view');
        Route::put('/{id}',                [RepairController::class, 'update'])        ->middleware('can:repairs.update');
        Route::delete('/{id}',             [RepairController::class, 'destroy'])       ->middleware('can:repairs.delete');
        Route::post('/{id}/change-status', [RepairController::class, 'changeStatus'])  ->middleware('can:repairs.change_status');
        Route::post('/{id}/send-survey',   [RepairController::class, 'sendSurvey'])    ->middleware('can:repairs.send_survey');
    });

    // --- Notifications ---
    // Según tu requerimiento inicial, el método era 'send' o 'sendEmail'
    Route::prefix('notifications')->middleware('can:notifications.send')->group(function () {
        Route::post('/send',                   [NotificationController::class, 'send']);
        Route::post('/send-welcome',           [NotificationController::class, 'sendWelcome']);
        Route::post('/send-order-confirmation',[NotificationController::class, 'sendOrderConfirmation']);
        Route::post('/send-invoice',           [NotificationController::class, 'sendInvoice']);
    });
    
    // --- Inventory ---
    Route::prefix('inventory')->group(function () {
        Route::get('/',                    [InventoryController::class, 'index'])        ->middleware('can:inventory.view');
        Route::get('/{id}',                [InventoryController::class, 'show'])         ->middleware('can:inventory.view');
        Route::post('/',                   [InventoryController::class, 'store'])        ->middleware('can:inventory.create');
        Route::delete('/{id}',             [InventoryController::class, 'destroy'])      ->middleware('can:inventory.delete');
        Route::post('/{id}/change-status', [InventoryController::class, 'changeStatus']) ->middleware('can:inventory.change_status');
    });  
});