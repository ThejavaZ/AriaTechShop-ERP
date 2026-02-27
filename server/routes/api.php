<?php

use App\Http\Controllers\api\UserController as ApiUserController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;

Route::middleware('auth:sanctum')->group(function(){
    Route::resource('/', ApiUserController::class);
    Route::apiResource('sales', SaleController::class);

});
