<?php

use App\Http\Controllers\api\UserController as ApiUserController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\Api\NotificationController;

Route::middleware('auth:sanctum')->group(function(){
    Route::resource('/', ApiUserController::class);
    Route::apiResource('sales', SaleController::class);
    // Route::get('/sales/chart', [SaleController::class, 'salesChart']);

});

Route::get('/sales/chart', [SaleController::class, 'salesChart']);

Route::prefix('notifications')->group(function () {
    Route::post('/send-email', [NotificationController::class, 'sendEmail']);
    Route::post('/send-welcome', [NotificationController::class, 'sendWelcome']);
    Route::post('/send-order-confirmation', [NotificationController::class, 'sendOrderConfirmation']);
    Route::post('/send-invoice', [NotificationController::class, 'sendInvoice']);
});

use App\Http\Controllers\RepairController;

Route::prefix('repairs')->group(function () {
    Route::get('/', [RepairController::class, 'index']);
    Route::post('/', [RepairController::class, 'store']);
    Route::get('/{id}', [RepairController::class, 'show']);
    Route::put('/{id}', [RepairController::class, 'update']);
    Route::delete('/{id}', [RepairController::class, 'destroy']);
    Route::post('/{id}/change-status', [RepairController::class, 'changeStatus']);
    Route::post('/{id}/send-survey', [RepairController::class, 'sendSurvey']);
});


