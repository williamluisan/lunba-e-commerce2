<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Product\ProductController;

Route::apiResource('user', UserController::class);
Route::apiResource('product', ProductController::class);

// Route::prefix('user')->group(function() {
//     Route::post('/', [User::class, 'create']);
// });

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');