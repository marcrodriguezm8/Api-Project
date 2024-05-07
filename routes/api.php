<?php

use Illuminate\Http\Request;
use App\Models\ProductProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\ProviderController;
use App\Http\Controllers\api\ProductProviderController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::resource('products', ProductController::class);
    Route::resource('providers', ProviderController::class);
    Route::resource('products-providers', ProductProviderController::class);
});


