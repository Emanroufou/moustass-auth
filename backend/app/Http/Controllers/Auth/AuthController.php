<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // 1. Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'min:12',
                'regex:/[A-Z]/',      // 1 majuscule
                'regex:/[a-z]/',      // 1 minuscule
                'regex:/[0-9]/',      // 1 chiffre
                'regex:/[^A-Za-z0-9]/' // 1 caractère spécial
            ],
        ]);

        // 2. Création de l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'CLIENT',
        ]);

        // 3. Réponse API
        return response()->json([
            'message' => 'User registered successfully',
            'user_id' => $user->id,
        ], 201);
    }
}