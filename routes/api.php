<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\AuthController;

// Auth Routes
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Movie API Routes
    Route::prefix('movies')->group(function () {
        Route::get('/', [MovieController::class, 'index']);
        Route::get('/{movie}', [MovieController::class, 'show']);
        Route::post('/', [MovieController::class, 'store']);
        Route::put('/{movie}', [MovieController::class, 'update']);
        Route::delete('/{movie}', [MovieController::class, 'destroy']);
    });
});

