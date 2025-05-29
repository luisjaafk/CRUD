<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;


Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [LoginController::class, 'loginProcess']);
Route::get('/activate-account/{token}', [LoginController::class, 'validateAccount']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/me', [LoginController::class, 'me']);

    Route::get('/usuarios', [UserController::class, 'index']);
    Route::post('/usuarios', [UserController::class, 'store']);
    Route::get('/usuarios/{id}', [UserController::class, 'show']);
    Route::put('/usuarios/{id}', [UserController::class, 'update']);
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy']);

    Route::get('/posts', [BlogController::class, 'index']);
    Route::post('/posts', [BlogController::class, 'store']);
    Route::get('/posts/{id}', [BlogController::class, 'show']);
    Route::put('/posts/{id}', [BlogController::class, 'update']);
    Route::delete('/posts/{id}', [BlogController::class, 'destroy']);
});
