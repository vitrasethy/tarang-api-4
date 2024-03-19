<?php

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SportTypeController;
use App\Http\Controllers\VenueController;
use App\Models\Announcement;
use App\Models\MatchGame;
use App\Models\Team;
use App\Models\TempRecruitment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('sport-types', SportTypeController::class);
Route::apiResource('venues', VenueController::class);
Route::apiResource('reservation', ReservationController::class);
Route::apiResource('teams', Team::class);
Route::apiResource('announcements', Announcement::class);
Route::apiResource('match-games', MatchGame::class);
Route::apiResource('temp-recruitments', TempRecruitment::class);
