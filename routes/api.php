<?php

use App\Http\Controllers\AmenityController;
use App\Http\Controllers\GetUserController;
use App\Http\Controllers\MatchGameController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SportTypeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TempRecruitmentController;
use App\Http\Controllers\VenueController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('is-login', function () {
    if (Auth::check()){
        return response()->json(['message' => 'Authorized']);
    }else return response()->json(['message' => 'Unauthorized']);
});

Route::apiResource('sport-types', SportTypeController::class);
Route::apiResource('venues', VenueController::class);
Route::apiResource('reservation', ReservationController::class);
Route::apiResource('teams', TeamController::class);
Route::apiResource('match-games', MatchGameController::class);
Route::apiResource('temp-recruitments', TempRecruitmentController::class);
Route::apiResource('amenities', AmenityController::class);
Route::get('user-data', GetUserController::class);
Route::get('reservations-user', [ReservationController::class, 'show_user']);
