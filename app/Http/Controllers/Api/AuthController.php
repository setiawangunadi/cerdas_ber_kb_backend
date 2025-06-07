<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //register user
    public function register(Request $request) 
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'password' => 'required|string'
        ]);

        //create user
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        //return response
        return response()->json([
            'statues' => 'success',
            'message' => 'User created successfully',
        ], 201);
    }

    public function login(Request $request)
    {
        //validate the request
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string'
        ]);

        //check the user
        $user = User::where('phone', $request->phone)->first();

        //check if user not found
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        //generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        //response
        return response()->json([
            'status' => 'success',
            'message' => 'User login successfully',
            'data' => [
                'token' => $token,
                'name' => $user->name,
                'phone' => $user->phone,
            ]
        ], 200);
    }

    public function logout(Request $request) 
    {
        //revoke token
        $request->user()->currentAccessToken()->delete();

        //return response
        return response()->json([
            'status' => 'success',
            'message' => 'User logged out successfully',
        ], 200);
    }

    //edit user
    public function update(Request $request)
    {
        $user = Auth::user(); // Get the currently authenticated user

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->save();

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'confirmed'], // new_password_confirmation field required
        ]);

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            //return response
            return response()->json([
                'status' => 'error',
                'message' => 'Current password is incorrect',
            ], 403);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        //return response
        return response()->json([
            'status' => 'success',
            'message' => 'Password changed successfully',
        ], 200);
    }
}
