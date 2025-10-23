<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return response()->json(['message' => 'Personal Finance Tracker API']);
});

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
  // Auth
  Route::get('/user', [AuthController::class, 'user']);
  Route::post('/logout', [AuthController::class, 'logout']);

  // Dashboard
  Route::get('/dashboard', [DashboardController::class, 'index']);

  // Categories
  Route::apiResource('categories', CategoryController::class);

  // Transactions
  Route::apiResource('transactions', TransactionController::class);
});
