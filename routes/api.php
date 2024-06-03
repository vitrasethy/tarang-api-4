<?php

use App\Http\Controllers\AmenityController;
use App\Http\Controllers\GetAvailablesTimeController;
use App\Http\Controllers\MatchGameController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SportTypeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TestAuthAPI;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenueController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function () {
    return User::with('teams')->where('id', auth()->id())->first();
});

// Route protected
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('sport-types', SportTypeController::class)->except('index');
    Route::apiResource('reservation', ReservationController::class)->except('index');
    Route::apiResource('match-games', MatchGameController::class)->except('index');
    Route::apiResource('amenities', AmenityController::class)->except('index');
    Route::apiResource('venues', VenueController::class)->except('index');
    Route::apiResource('teams', TeamController::class);

    // list of users
    Route::get('users', [UserController::class, 'getAllUsers']);
});

// Route of major models which not protected
Route::get('venues', [VenueController::class, 'index']);
Route::get('amenities', [AmenityController::class, 'index']);
Route::get('match-games', [MatchGameController::class, 'index']);
Route::get('reservation', [ReservationController::class, 'index']);
Route::get('sport-types', [SportTypeController::class, 'index']);

// show reservation for each user
Route::get('reservations-user', [ReservationController::class, 'show_user']);

// get the available time for reservation
Route::post('available-time', GetAvailablesTimeController::class);

// send code to user for verified phone number
Route::post('verify-phone', [UserController::class, 'verify']);

// find is the reservation request is available or not
Route::post('find-reservation', [ReservationController::class, 'find_reservation']);


// testing in postman
Route::post('login', [TestAuthAPI::class, "login"]);
