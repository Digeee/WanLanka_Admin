<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'place_id' => 'required|integer|exists:places,id',
            'pickup_district' => 'required|string|max:255',
            'pickup_location' => 'required|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'people_count' => 'required|integer|min:1|max:12',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'vehicle_id' => 'required|integer|exists:vehicles,id',
            'guider' => 'required|in:yes,no',
            'total_price' => 'required|numeric|min:0',
        ]);

        $booking = Booking::create($validated);

        return response()->json([
            'message' => 'Booking created successfully',
            'booking_id' => $booking->id
        ], 201);
    }
}
