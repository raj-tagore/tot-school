<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\TallyController;
use App\Http\Controllers\Api\LeaderboardController;
use App\Http\Controllers\Api\AuthController;

// Authentication Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected Routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/attendance/mark', [AttendanceController::class, 'markAttendance']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/tally', [TallyController::class, 'index']);
    Route::post('/tally', [TallyController::class, 'store']);
    Route::get('/leaderboard', [LeaderboardController::class, 'index']);
    Route::get('/leaderboard/{key}', [LeaderboardController::class, 'show']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/columns', [DashboardController::class, 'columns']);
    Route::get('/announcement', [HomeController::class, 'announcement']);
});
