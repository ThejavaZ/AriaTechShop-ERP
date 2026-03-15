<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controladores con el namespace corregido (Api con A mayúscula)
use App\Http\Controllers\Api\UserController as ApiUserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController; // Corregido el APp
use App\Http\Controllers\SaleController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Rutas Protegidas
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function(){
    Route::resource('users', ApiUserController::class); // Evita usar '/' como nombre de recurso
    Route::apiResource('sales', SaleController::class);
});
