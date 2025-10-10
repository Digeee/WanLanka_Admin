<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Place;
use App\Models\Vehicle;
use Illuminate\Http\Request;


class AdminBookingController extends Controller
{
    /**
     * Display a listing of the bookings.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $bookings = Booking::with('vehicle')->get()->map(function ($booking) {
            $place = Place::where('id', $booking->place_id)->first();
            return [
                'id' => $booking->id,
                'place_name' => $place ? $place->name : 'Unknown',
                'pickup_district' => $booking->pickup_district,
                'pickup_location' => $booking->pickup_location,
                'full_name' => $booking->full_name ?? 'N/A',
                'email' => $booking->email ?? 'N/A',
                'latitude' => $booking->latitude ?? 'N/A',
                'longitude' => $booking->longitude ?? 'N/A',
                'people_count' => $booking->people_count,
                'date' => $booking->date,
                'time' => $booking->time,
                'vehicle_type' => $booking->vehicle ? $booking->vehicle->vehicle_type : 'N/A',
                'guider' => $booking->guider ?? 'No', // Remains as a string column
                'total_price' => number_format($booking->total_price, 2),
                'status' => $booking->status,
                'created_at' => $booking->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return view('admin.bookings.Individualplace_bookings.index', compact('bookings'));
    }

    /**
     * Show the form for editing the specified booking.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $booking = Booking::with('vehicle')->findOrFail($id);
        $place = Place::where('id', $booking->place_id)->first();
        $vehicles = Vehicle::where('status', 'available')->get();

        return view('admin.bookings.Individualplace_bookings.edit', compact('booking', 'place', 'vehicles'));
    }

    /**
     * Update the specified booking in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
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
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking->update($validated);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully');
    }

    /**
     * Remove the specified booking from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully');
    }
}
