<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class BookingController extends Controller
{
    
    public function getExpertBookings($expertId)
{
    // Fetch bookings where the expert_id matches the expert's user ID
    $bookings = Booking::where('expert_id', $expertId)->get();

    // Return the bookings in JSON format
    return response()->json([
        'success' => true,
        'message' => 'Expert bookings retrieved successfully',
        'data' => $bookings,
    ]);
}

public function getOngoingBookings($userId)
{
    // Logic to fetch ongoing bookings for the given expert
    $bookings = Booking::where('expert_id', $userId)->where('status', 'ongoing')->get();
    return response()->json($bookings);
}
    // Method to create a new booking
    public function store(Request $request)
{
    // Log the incoming request data
    Log::info('Booking Request Received:', $request->all());

    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'expert_id' => 'required|exists:users,id',
        'expert_name' => 'required|string',
        'user_name' => 'required|string',
        'status' => 'nullable|string',
        'timestamp' => 'nullable|date',
        'note' => 'nullable|string',
        'rate' => 'nullable|string',
        'expert_address' => 'nullable|string',
        'expert_image_url' => 'nullable|string',
        'user_address' => 'nullable|string',
    ]);

    // Log the validated data
    Log::info('Validated Booking Data:', $validated);

    $booking = Booking::create([
        'user_id' => $validated['user_id'],
        'expert_id' => $validated['expert_id'],
        'expert_name' => $validated['expert_name'],
        'user_name' => $validated['user_name'],
        'status' => $validated['status'] ?? 'Pending',  // Default to "Pending"
        'timestamp' => $validated['timestamp'] ?? now(),
        'note' => $validated['note'] ?? null,
        'rate' => $validated['rate'] ?? null,
        'expert_address' => $validated['expert_address'],
        'expert_image_url' => $validated['expert_image_url'] ?? null,
        'user_address' => $validated['user_address'] ?? null,
    ]);

    // Log the booking creation success
    Log::info('Booking Created Successfully:', ['booking_id' => $booking->id]);

    return response()->json([
        'success' => true,
        'message' => 'Booking Successful!',
        'data' => $booking
    ]);
}
public function getUserBookings($userId)
{
    $bookings = Booking::where('user_id', $userId)->get();

    return response()->json([
        'success' => true,
        'message' => 'User bookings retrieved successfully',
        'data' => $bookings,
    ]);
}
public function acceptBooking($id)
{
    $booking = Booking::find($id);

    if (!$booking) {
        return response()->json(['message' => 'Booking not found'], 404);
    }

    $booking->status = 'ongoing';
    $booking->save();

    return response()->json(['status'=>'status','message' => 'Booking accepted successfully', 'data' => $booking], 200);
}
public function declineBooking($bookingId)
    {
        // Find the booking by ID
        $booking = Booking::find($bookingId);

        if (!$booking) {
            return response()->json([
                'error' => 'Booking not found'
            ], Response::HTTP_NOT_FOUND);
        }

        // Check if the booking is already declined or completed
        if ($booking->status == 'declined' || $booking->status == 'completed') {
            return response()->json([
                'error' => 'Booking cannot be declined'
            ], Response::HTTP_BAD_REQUEST);
        }

        // Update the booking status to 'declined'
        $booking->status = 'declined';
        $booking->save();

        // Return the updated booking as a response
        return response()->json([
            'message' => 'Booking declined successfully',
            'data' => $booking
        ], Response::HTTP_OK);
    }


    // Method to update the booking status (e.g., to "Accepted" or "Completed")
    public function updateBookingStatus(Request $request, $id)
    {
        // Find the booking by ID
        $booking = Booking::find($id);

        if ($booking) {
            // Update the status
            $booking->status = 'cancelled';  // Set status to 'Cancelled'
            $booking->save();  // Save the updated booking

            return response()->json(['success' => true, 'message' => 'Booking updated successfully']);
        } else {
            return response()->json([
                'message' => 'Booking not found'
            ], 404);
        }
    }
}
