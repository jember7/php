<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Expert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // Register User
    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'profile_picture' => 'nullable|image|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Handle profile picture upload if exists
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('public/profile_pictures');
            $profilePicturePath = Storage::url($profilePicturePath);
        }

        // Create user
        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'profile_picture' => $profilePicturePath,
        ]);

        return response()->json(['message' => 'User registered successfully!', 'user' => $user], 201);
    }

    public function registerExpert(Request $request)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:experts,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'profession' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optional image validation
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Handle profile image upload
        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        // Create the expert in the database
        $expert = Expert::create([
            'full_name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')), // Hash the password
            'profession' => $request->input('profession'),
            'date_of_birth' => $request->input('date_of_birth'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
            'profile_image' => $profileImagePath, // Store the image path
        ]);

        // Return success response
        return response()->json([
            'message' => 'Expert registered successfully.',
            'expert' => $expert,
        ], 201);
    }


}
