<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ExpenseController;
use Illuminate\Http\Request;

// Route::post('/login', [Auth::class, 'auth']);


Route::prefix('auth')
->middleware([
    'auth:sanctum',
    ])
    ->group(function () {
        Route::get('/me', fn(Request $request) => $request->user());

        Route::post('/login', [AuthController::class, 'auth'])->withoutMiddleware([
            'auth:sanctum',
        ]);
    });

Route::get('/greeting', function () {
    return 'Hello World';
});

Route::post('/users', [UserController::class, 'post']);

Route::apiResource('expenses', ExpenseController::class);
