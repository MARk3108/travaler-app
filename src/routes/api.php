<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Route\RouteController;
use Illuminate\Support\Facades\Route;

Route::get('/hello', function () {
    return response()->json(['message' => 'Hello World!']);
});

Route::prefix('auth')->group(function (): void {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::middleware('auth:sanctum')->group(function (): void {
    Route::get('/routes', [RouteController::class, 'getRoutesByType']);
    Route::get('/route/pois', [RouteController::class, 'getRouteWithPOI']);
    Route::post('/route/favorite', [RouteController::class, 'addToFavorite']);
    Route::post('/route/add', [RouteController::class, 'createNewRoute']);
    Route::get('/recomendations', [RouteController::class, 'getRecomendations']);
});
