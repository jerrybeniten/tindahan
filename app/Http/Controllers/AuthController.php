<?php

// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate login credentials
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to login
        if (Auth::attempt($credentials)) {
            // Authentication passed
            return response()->json(['message' => 'Login successful']);
        }

        // Authentication failed
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();  // Logout the user
        return response()->json(['message' => 'Logout successful']);
    }
}
