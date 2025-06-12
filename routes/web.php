<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\InvestmentController;
use App\Http\Controllers\API\InvestmentPlanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auuthentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/plans', [InvestmentPlanController::class, 'index']);

    Route::get('/investments', [InvestmentController::class, 'index']);
    Route::post('/investments', [InvestmentController::class, 'store']);
    Route::post('/investments/{id}/withdraw', [InvestmentController::class, 'withdraw']);
});
