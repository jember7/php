<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\BookingController;



Route::post('/register', [AuthController::class, 'registerUser']);
// Expert Registration Route
Route::post('/register/expert', [AuthController::class, 'registerExpert']);
// Login Route
Route::post('/login', [LoginController::class, 'login']);
Route::get('/user-profile', [UserController::class, 'getUserProfile']);
Route::get('/user-profile2', [UserController::class, 'getUserProfile']);
Route::put('/user/{userId}', [UserController::class, 'updateUserProfile']);
Route::post('change-password/{userId}', [UserController::class, 'changePassword']);

Route::get('/expert-profile', [ExpertController::class, 'getExpertProfile']);
Route::post('/bookings', [BookingController::class, 'store']);
Route::get('/bookings/user/{userId}', [BookingController::class, 'getUserBookings']);
Route::get('/bookings/expert/{expertId}', [BookingController::class, 'getExpertBookings']);
Route::get('expert/by-email/{email}', [ExpertController::class, 'getExpertIdByEmail']);
Route::put('/bookings/{id}/status', [BookingController::class, 'updateBookingStatus']);
Route::put('/bookings/{id}/accept', [BookingController::class, 'acceptBooking']);
Route::put('/bookings/{id}/decline', [BookingController::class, 'declineBooking']);
Route::put('expert/update/{id}', [ExpertController::class, 'updateExpertProfile']);

Route::get('expert/{userId}/bookings', [BookingController::class, 'getExpertBookings']);
Route::get('expert/{userId}/ongoing-bookings', [BookingController::class, 'getOngoingBookings']);

Route::get('experts', [ExpertController::class, 'getExpertsByProfession']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
