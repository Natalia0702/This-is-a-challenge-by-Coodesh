<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

// Route::post('/login', [Auth::class, 'auth']);

Route::post('/login', [AuthController::class, 'auth']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/greeting', function () {
    return 'Hello World';
});
Route::post('/users',  [UserController::class, 'post']);

Route::get('/expenses', [ExpenseController::class, 'getAll']);

Route::post('/expenses', [ExpenseController::class, 'store']);

Route::middleware('auth:sanctum')->get('/expenses/{id}', [ExpenseController::class, 'getById']);

Route::middleware('auth:sanctum')->delete('/expenses/{id}', [ExpenseController::class, 'destroy']);

Route::middleware('auth:sanctum')->put('/expenses/{id}', [ExpenseController::class, 'put']);