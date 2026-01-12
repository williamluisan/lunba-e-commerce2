<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Product\ProductController;

Route::prefix('auth')->group(function() {
    Route::post('/login', [LoginController::class, 'authenticate']);
});

// regular
// Route::apiResource('user', UserController::class);
// Route::apiResource('product', ProductController::class);

// with sanctum
Route::apiResource('user', UserController::class);
Route::apiResource('product', ProductController::class)->middleware("auth:sanctum");

// Route::prefix('user')->group(function() {
//     Route::post('/', [User::class, 'create']);
// });

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');