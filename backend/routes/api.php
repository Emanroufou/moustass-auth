<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\UserController;



Route::middleware('auth:api')->get('/auth/me', function (Request $request) {
    return response()->json($request->user());
});





Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/health', function () {
    return response()->json([
        'status' => 'OK',
        'service' => 'Moustass Auth API'
    ]);
});
Route::middleware(['auth:api', 'admin'])->get('/admin/test', function () {
    return response()->json([
        'message' => 'Welcome Admin'
    ]);
});

Route::middleware(['auth:api', 'admin'])->get('/admin/users', [UserController::class, 'index']);
Route::middleware(['auth:api', 'admin'])
    ->post('/admin/users', [UserController::class, 'store']);
    Route::middleware(['auth:api', 'admin'])
    ->put('/admin/users/{id}', [UserController::class, 'update']);

    Route::middleware(['auth:api', 'admin'])
    ->delete('/admin/users/{id}', [UserController::class, 'destroy']);
Route::middleware(['auth:api', 'admin'])
    ->delete('/admin/users/{id}', [UserController::class, 'destroy']);



