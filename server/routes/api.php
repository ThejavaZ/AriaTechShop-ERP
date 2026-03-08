<?php

use App\Http\Controllers\api\AuthController as ApiAuthController;
use App\Http\Controllers\api\UserController as ApiUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;

Route::get('/auth/login',[ApiAuthController::class, 'login']);
Route::post('/auth/register',[ApiAuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('/', ApiUserController::class);
    Route::apiResource('sales', SaleController::class);

});