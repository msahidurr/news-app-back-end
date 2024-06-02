<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'dob'           => 'nullable|string|date_format:Y-m-d',
            'firebase_uuid' => 'nullable|string|max:255',
            'device_token'  => 'nullable|string|max:255',
            'email'         => 'nullable|string|email|max:255|unique:users',
            'password'      => 'required|string|min:8',
        ]);

        $user = User::create([
            'username'      => uniqid(),
            'dob'           => $request->dob,
            'email'         => $request->email,
            'firebase_uuid' => $request->firebase_uuid,
            'device_token'  => $request->device_token,
            'password'      => Hash::make($request->password),
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where(function($query) use ($request) {
            $query->where('email', $request->username)
                ->orWhere('username', $request->username);
        })->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}
