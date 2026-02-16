<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'role', 'created_at')->get();

        return response()->json($users);
    }
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => [
            'required',
            'min:12',
            'regex:/[A-Z]/',
            'regex:/[a-z]/',
            'regex:/[0-9]/',
            'regex:/[^A-Za-z0-9]/'
        ],
        'role' => 'required|in:ADMIN,CLIENT'
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $request->role,
    ]);

    return response()->json([
        'message' => 'User created',
        'user' => $user
    ], 201);
}
public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|unique:users,email,' . $id,
        'role' => 'sometimes|in:ADMIN,CLIENT'
    ]);

    $user->update($request->only('name', 'email', 'role'));

    return response()->json([
        'message' => 'User updated',
        'user' => $user
    ]);
}
public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return response()->json([
        'message' => 'User deleted'
    ]);
}



}
