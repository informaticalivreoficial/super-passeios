<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\TourController;
use App\Http\Controllers\Api\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Públicas
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/tours', [TourController::class, 'index']);
    Route::get('/tours/{tour:slug}', [TourController::class, 'show']);
    Route::get('/tours/{tour:slug}/dates', [TourController::class, 'dates']);

    // Protegidas (precisa de token)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);

        Route::get('/bookings', [BookingController::class, 'index']);
        Route::get('/bookings/{booking:uuid}', [BookingController::class, 'show']);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/webhook/mercadopago', [WebhookController::class, 'mercadopago'])
    ->name('webhook.mercadopago');
