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
            'place_id' => 'required|string',
            'pickup_district' => 'required|string',
            'pickup_location' => 'required|string',
            'people_count' => 'required|integer|min:1',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'vehicle_id' => 'required|integer|exists:vehicles,id',
            'total_price' => 'required|numeric|min:0',
            'guider' => 'nullable|in:yes,no', // Added for guider
        ]);

        $booking = Booking::create($validated);

        return response()->json(['message' => 'Booking created successfully', 'booking_id' => $booking->id], 201);
    }
}
