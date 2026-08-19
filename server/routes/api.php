<?php

use App\Http\Controllers\Api\UserController as ApiUserController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use iluminate\Support\Facades\DB;

use App\Http\Controllers\SaleController;

// --- CONTROLADORES DE TUS COMPAÑEROS ---
use App\Http\Controllers\SaleDetailController;

use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);


use App\Http\Controllers\RepairController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas (Auth y Catálogo)
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Auth:Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function(){
    Route::resource('users', ApiUserController::class);
    Route::apiResource('sales', SaleController::class);
});

/*
|--------------------------------------------------------------------------
| Ventas, Notificaciones y Reparaciones (Compañeros)
|--------------------------------------------------------------------------
*/
Route::get('/sales/chart', [SaleController::class, 'salesChart']);

Route::prefix('notifications')->group(function () {
    Route::post('/send-email', [NotificationController::class, 'sendEmail']);
    Route::post('/send-welcome', [NotificationController::class, 'sendWelcome']);
    Route::post('/send-order-confirmation', [NotificationController::class, 'sendOrderConfirmation']);
    Route::post('/send-invoice', [NotificationController::class, 'sendInvoice']);
});

Route::prefix('repairs')->group(function () {
    Route::get('/', [RepairController::class, 'index']);
    Route::post('/', [RepairController::class, 'store']);
    Route::get('/{id}', [RepairController::class, 'show']);
    Route::put('/{id}', [RepairController::class, 'update']);
    Route::delete('/{id}', [RepairController::class, 'destroy']);
    Route::post('/{id}/change-status', [RepairController::class, 'changeStatus']);
    Route::post('/{id}/send-survey', [RepairController::class, 'sendSurvey']);


    Route::get('/sales/{sale_id}/details', [SaleDetailController::class, 'index']);
    Route::post('/sales/details', [SaleDetailController::class, 'store']);
    Route::delete('/sales/details/{id}', [SaleDetailController::class, 'destroy']);




});


