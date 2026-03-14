<?php

use App\Http\Controllers\api\UserController as ApiUserController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CategoryController;
use APp\Http\Controllers\api\ProductController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);


Route::middleware('auth:sanctum')->group(function(){
    Route::resource('/', ApiUserController::class);
    Route::apiResource('sales', SaleController::class);

});
