<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserController extends Controller
{

public function getUserProfile(Request $request)
{
    // Get the user ID from the query parameter
    $userId = $request->query('id');

    // Find the user by the provided ID
    $user = User::find($userId);

    // Check if the user exists
    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }
    
    // Return the user's profile data
    return response()->json($user);
}
public function updateUserProfile(Request $request, $id)
{
    $user = User::find($id);
    // Validate and update user data
    $user->update($request->all());
    return response()->json($user);
}

public function uploadProfileImage(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $path = $file->store('profile_images', 'public'); // Store image in public storage

            $user->profile_picture = $path;
            $user->save();

            return response()->json(['message' => 'Profile image uploaded successfully', 'image_url' => $path], 200);
        }

        return response()->json(['message' => 'No image uploaded'], 400);
    }
    public function changePassword(Request $request, $userId)
{
    // Validate inputs
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
    ]);

    // Find the user by ID
    $user = User::find($userId);

    // Check if the user exists
    if (!$user) {
        return response()->json(['error' => 'User not found.'], 404);
    }

    // Check if the current password is correct
    if (Hash::check($request->current_password, $user->password)) {
        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully.'], 200);
    }

    return response()->json(['error' => 'Current password is incorrect.'], 400);
}

}