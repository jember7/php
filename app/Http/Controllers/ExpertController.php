<?php

namespace App\Http\Controllers;
use App\Models\Expert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpertController extends Controller
{

    public function getExpertIdByEmail(Request $request)
{
    $email = $request->query('email'); // or 'name' if using fullName
    $expert = Expert::where('email', $email)->first();

    if ($expert) {
        return response()->json(['id' => $expert->id], 200);
    } else {
        return response()->json(['error' => 'Expert not found'], 404);
    }
}
    public function getExpertProfile(Request $request)
{
    // Get the userId from the query parameter
    $userId = $request->query('userId');
    
    // Fetch the expert profile using the userId
    $expert = Expert::find($userId);

    if (!$expert) {
        return response()->json(['message' => 'Expert not found'], 404);
    }

    return response()->json($expert);
}
public function updateExpertProfile(Request $request, $id)
{
    $expert = Expert::find($id);
    // Validate and update user data
    $expert->update($request->all());
    return response()->json($expert);
}

public function getExpertsByProfession(Request $request)
{
    $profession = $request->input('profession');
    
    // Fetch experts who match the profession
    $experts = Expert::where('role', 'Expert')->where('profession', $profession)->get();

    return response()->json($experts);
}
}
