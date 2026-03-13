<?php

use App\Http\Controllers\api\UserController as ApiUserController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);


Route::middleware('auth:sanctum')->group(function(){


    Route::get('/users', [ApiUserController::class, 'index']);
    Route::apiResource('/sales', SaleController::class);

});