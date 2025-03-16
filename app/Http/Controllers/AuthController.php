<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    // Registration Form web
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Login Form web
    public function showLoginForm()
    {
        return view('auth.login'); 
    }

    // User Registration
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'address' => 'sometimes|string',
            'city' => 'sometimes|string',
            'state' => 'sometimes|string',
            'zipcode' => 'sometimes|string',
            'country' => 'sometimes|string',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
        ]);

        if ($request->wantsJson()) {
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'User registered successfully!',
                'token' => $token,
                'user' => $user
            ], 201);
        }

        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }

    // User Login API & Web
    public function login(Request $request)
    {
        if ($request->wantsJson()) {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string|min:6',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful!',
                'token' => $token,
                'user' => $user
            ], 200);
        }

        // Web Login
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->intended('/');
        }

        return redirect()->route('login')->withErrors(['email' => 'Invalid credentials']);
    }

    // User Logout API & Web
    public function logout(Request $request)
    {
        if ($request->wantsJson()) {
            $request->user()->tokens()->delete();
            return response()->json(['message' => 'Logged out successfully!'], 200);
        }

        // Web Logout
        Auth::logout();
        return redirect()->route('login')->with('message', 'You have been logged out.');
    }
}
