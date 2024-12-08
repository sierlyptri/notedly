<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller {
    public function showRegisterForm() {
        return view('auth.register');
    }

    public function register(Request $request)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    // Membuat user baru
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Membuat token untuk user
    $token = $user->createToken('MyApp')->accessToken;

    return response()->json([
        'status' => true,
        'message' => 'User successfully created',
        'data' => $user,
        'token' => $token
    ], 201);
}

    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}