<?php

use App\Http\Controllers\MatchController;
use App\Http\Controllers\StandingController;
use App\Http\Controllers\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/teams', [TeamController::class, 'index']);

Route::post('/match', [MatchController::class, 'store']);
Route::get('/match/statistics', [MatchController::class, 'matchStatistics']);

Route::get('/standing', [StandingController::class, 'index']);
