<?php

use App\Http\Controllers\AmenityController;
use App\Http\Controllers\GetAvailablesTimeController;
use App\Http\Controllers\MatchGameController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SportTypeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenueController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function () {
    return User::with('teams')->where('id', auth()->id())->first();
});

Route::apiResources([
    'sport-types' => SportTypeController::class,
    'reservation' => ReservationController::class,
    'match-games' => MatchGameController::class,
    'amenities' => AmenityController::class,
]);
Route::get('reservations-user', [ReservationController::class, 'show_user']);
Route::get('users', [UserController::class, 'getAllUsers'])->middleware('auth:sanctum');
Route::post('available-time', GetAvailablesTimeController::class);
Route::post('verify-phone', [UserController::class, 'verify']);

Route::apiResource('teams', TeamController::class)->middleware('auth:sanctum');
Route::apiResource('venues', VenueController::class)->middleware('auth:sanctum');

// Mobile Endpoint
// Route::post('login', [UserController::class, 'login']);
// Route::get('mobile/reservations', [MobileReservationController::class, 'index']);
