<?php

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SportTypeController;
use App\Http\Controllers\VenueController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('sport-types', SportTypeController::class);
Route::apiResource('venues', VenueController::class);
Route::apiResource('reservation', ReservationController::class);
