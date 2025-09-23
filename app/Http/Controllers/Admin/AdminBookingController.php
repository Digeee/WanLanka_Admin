<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Place;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('vehicle')->get()->map(function ($booking) {
            $place = Place::where('id', $booking->place_id)->first();
            return [
                'id' => $booking->id,
                'place_name' => $place ? $place->name : 'Unknown',
                'pickup_district' => $booking->pickup_district,
                'pickup_location' => $booking->pickup_location,
                'people_count' => $booking->people_count,
                'date' => $booking->date,
                'time' => $booking->time,
                'vehicle_type' => $booking->vehicle ? $booking->vehicle->vehicle_type : 'N/A',
                'guider' => $booking->guider ?? 'No',
                'total_price' => number_format($booking->total_price, 2),
                'status' => $booking->status,
                'created_at' => $booking->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return view('admin.bookings.index', compact('bookings'));
    }

    public function edit($id)
    {
        $booking = Booking::with('vehicle')->findOrFail($id);
        $place = Place::where('id', $booking->place_id)->first();
        $vehicles = Vehicle::where('status', 'available')->get();
        return view('admin.bookings.edit', compact('booking', 'place', 'vehicles'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $validated = $request->validate([
            'pickup_district' => 'required|string',
            'pickup_location' => 'required|string',
            'people_count' => 'required|integer|min:1',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'vehicle_id' => 'required|integer|exists:vehicles,id',
            'total_price' => 'required|numeric|min:0',
            'guider' => 'nullable|in:yes,no',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking->update($validated);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully');
    }
}
