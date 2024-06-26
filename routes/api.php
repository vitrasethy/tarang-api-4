<?php

use App\Http\Controllers\AmenityController;
use App\Http\Controllers\GetAvailablesTimeController;
use App\Http\Controllers\MatchGameController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ProviderPhoneNumberController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SportTypeController;
use App\Http\Controllers\TestAuthAPI;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenueController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function () {
    return User::where('id', auth()->id())->first();
});

// Route protected
Route::middleware('auth:sanctum')->group(function () {
    // get report
    Route::post('reservation/custom-report', [ReservationController::class, 'custom_report']);
    Route::get('reservation/report', [ReservationController::class, 'report']);
    Route::get('venues/report', [VenueController::class, 'report']);
    Route::get('reservation/pending', [ReservationController::class, 'pending']);
    Route::get('reservation/month', [ReservationController::class, 'get_month_reservation']);

    Route::apiResource('sport-types', SportTypeController::class)->except('index');
    Route::apiResource('reservation', ReservationController::class)->except('index');
    Route::apiResource('match-games', MatchGameController::class)->except('index');
    Route::apiResource('amenities', AmenityController::class)->except('index');
    Route::apiResource('venues', VenueController::class)->except(['index', 'show']);

    // list of users
    Route::get('users', [UserController::class, 'getAllUsers']);

    // get report
    Route::post('reservation/custom-report', [ReservationController::class, 'custom_report']);
    Route::get('reservation/report', [ReservationController::class, 'report']);
    Route::get('venues/report', [VenueController::class, 'report']);
    Route::get('reservation/pending', [ReservationController::class, 'pending']);

    // show reservation for each user
    Route::get('reservations-user', [ReservationController::class, 'show_user']);

    // show reservation for each user history
    Route::get('reservations-user/history', [ReservationController::class, 'show_user_history']);

    // accept opp team for playing
    Route::put('match-games/accept/{matchGame}', [MatchGameController::class, 'accepting']);

    Route::post('/user/phone', [ProviderPhoneNumberController::class, 'store']);
    Route::post('/user/phone/verify', [ProviderPhoneNumberController::class, 'verify']);
    Route::delete('/match-games/{matchGame}/{user}', [MatchGameController::class, 'reject']);

    Route::post("/provider/phone", [ProviderController::class, "add_user_phone"]);
});

// Route of major models which not protected
Route::get('venues', [VenueController::class, 'index']);
Route::get('venues/{venue}', [VenueController::class, 'show']);
Route::get('amenities', [AmenityController::class, 'index']);
Route::get('match-games', [MatchGameController::class, 'index']);
Route::get('reservation', [ReservationController::class, 'index']);
Route::get('sport-types', [SportTypeController::class, 'index']);

// get the available time for reservation
Route::post('available-time', GetAvailablesTimeController::class);

// send code to user for verified phone number
Route::post('verify-phone', [UserController::class, 'verify']);

// find is the reservation request is available or not
Route::post('find-reservation', [ReservationController::class, 'find_reservation']);


// testing in postman
Route::post('login', [TestAuthAPI::class, "login"]);
