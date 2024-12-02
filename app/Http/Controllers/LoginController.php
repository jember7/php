<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Expert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to find the user or expert by email
        $user = User::where('email', $request->email)->first();
        $expert = Expert::where('email', $request->email)->first();

        // Check if user or expert exists and password is correct
        if ($user && Hash::check($request->password, $user->password)) {
            $role = 'user';
            $userId = $user->id;
        } elseif ($expert && Hash::check($request->password, $expert->password)) {
            $role = 'expert';
            $userId = $expert->id;
        } else {
            // Return error if credentials are incorrect
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Generate the token (assuming you're using Laravel Sanctum)
        $token = ($role == 'user') 
            ? $user->createToken('UserToken')->plainTextToken 
            : $expert->createToken('ExpertToken')->plainTextToken;

        // Return token and role for the frontend
        return response()->json([
            'message' => 'Login successful',
            'user_id' => $userId, // This will be either user or expert's ID
            'role' => $role,       // This will be either 'user' or 'expert'
            'email' => ($role == 'user') ? $user->email : $expert->email,
            'address' => ($role == 'user') ? $user->address : $expert->address,
            'token' => $token      // Include the generated token
        ], 200);
    }
}
