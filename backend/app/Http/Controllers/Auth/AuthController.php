<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;


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
      $token = JWTAuth::fromUser($user);

return response()->json([
    'message' => 'Login successful',
    'token' => $token,
    'user' => $user
]);

    }
    public function login(Request $request)
{
    // 1. Validation
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    // 2. Récupérer l'utilisateur
    $user = User::where('email', $request->email)->first();

    // 3. Vérifier le mot de passe
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    // 4. Réponse succès (sans JWT aujourd’hui)
 $token = JWTAuth::fromUser($user);

return response()->json([
    'message' => 'Login successful',
    'token' => $token,
    'user' => $user
], 200);

}
}