<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {

        $user = Auth::user();
    
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Please login to update your profile.'
            ], 401);
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'current_password' => 'required_with:new_password',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        // Update name and email
        $user->name = $request->name;
        $user->email = $request->email;

        // Update password if provided
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Password saat ini tidak cocok'
                ], 422);
            }

            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => $user
        ]);
    }
}