<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }

        return response()->json([
            'message' => 'Successfully authenticated',
            'data' => [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ]);
    }

    public function logout()
    {
        $authenticated = auth()->user();
        if (is_null($authenticated))
        {
            return response()->json(['message' => 'You are not logged in'], 404);
        }

        auth()->logout();
        return response()->json(['message' => 'Logged out successfully'], 205);
    }
}
