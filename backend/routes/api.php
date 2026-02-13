<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;

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
