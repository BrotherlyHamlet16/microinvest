<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UserRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // register(Request $request) Function to handle user registration
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required | string | max:255',
            'email'    => 'required | string | email | unique:users',
            'password' => 'required | string | min:6 | confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->notify(new UserRegistered());

        return response()->json([
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user'  => $user->createToken('api-token')->plainTextToken,
        ], 201);
    }

    // login(Request $request) Function to handle user login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required | email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user'  => $user->createToken('api-token')->plainTextToken,
        ]);
    }

    // logout(Request $request) Function to handle user logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
