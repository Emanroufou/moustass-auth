<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;



Route::post('/auth/register', [AuthController::class, 'register']);
Route::get('/health', function () {
    return response()->json([
        'status' => 'OK',
        'service' => 'Moustass Auth API'
    ]);
});
