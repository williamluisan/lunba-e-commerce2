<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\Payment\PaymentController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Middleware\JWTMiddleware;

Route::prefix('auth')->group(function() {
    Route::post('/login', [LoginController::class, 'authenticate']);
});

/* regular */
Route::post('/register', [RegisterController::class, 'store']);
// Route::apiResource('user', UserController::class);
// Route::apiResource('product', ProductController::class);

// Route::prefix('user')->group(function() {
//     Route::post('/', [User::class, 'create']);
// });

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

/* with JWT */
if (env('JWT_IS_ENABLED')):
    Route::middleware([JWTMiddleware::class])->group(function () {
        Route::apiResource('user', UserController::class);
        Route::apiResource('product', ProductController::class);
    });
endif;

/* with sanctum */
if (env('SANCTUM_IS_ENABLED')):
    Route::apiResource('user', UserController::class)->middleware("auth:sanctum");
    Route::apiResource('product', ProductController::class)->middleware("auth:sanctum")->middleware(['throttle:api']);
endif;