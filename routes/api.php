<?php

use App\Http\Controllers\AmenityController;
use App\Http\Controllers\GetAvailablesTimeController;
use App\Http\Controllers\MatchGameController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SportTypeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TempRecruitmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenueController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function () {
    return auth()->user();
});

Route::apiResources([
    'sport-types' => SportTypeController::class,
    'reservation' => ReservationController::class,
    'teams' => TeamController::class,
    'match-games' => MatchGameController::class,
    'temp-recruitments' => TempRecruitmentController::class,
    'amenities' => AmenityController::class,
    'venues' => VenueController::class,
]);
Route::get('reservations-user', [ReservationController::class, 'show_user']);
Route::get('users', [UserController::class, 'getAllUsers']);
Route::post('available-time', GetAvailablesTimeController::class);
Route::post('verify-phone', [UserController::class, 'verify']);

// Mobile Endpoint
Route::post('login', [UserController::class, 'login']);
