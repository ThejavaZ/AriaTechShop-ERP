<?php

use App\Http\Controllers\api\UserController as ApiUserController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function(){
    Route::resource('/', ApiUserController::class);

});
