<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Place;
use App\Models\Vehicle;
use App\Models\Guider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingAssignmentMail;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('vehicle', 'guider')->get()->map(function ($booking) {
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
                'guider' => $booking->guider ?? 'No',
                'total_price' => $booking->total_price, // Return as numeric value, not formatted string
                'status' => $booking->status,
                'created_at' => $booking->created_at->format('Y-m-d H:i:s'),
            ];
        });
        return view('admin.bookings.Individualplace_bookings.index', compact('bookings'));
    }

    public function edit($id)
    {
        $booking = Booking::with('vehicle', 'guider')->findOrFail($id);
        $place = Place::where('id', $booking->place_id)->first();
        $vehicles = Vehicle::all();
        $guiders = Guider::where('availability', true)->get();
        return view('admin.bookings.Individualplace_bookings.edit', compact('booking', 'place', 'vehicles', 'guiders'));
    }

    public function update(Request $request, $id)
    {
        try {
            $booking = Booking::findOrFail($id);

            // Store old values before updating
            $oldGuiderId = $booking->guider_id;
            $oldVehicleId = $booking->vehicle_id;

            $validated = $request->validate([
                'pickup_district' => 'required|string|max:255',
                'pickup_location' => 'required|string|max:500',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'people_count' => 'required|integer|min:1|max:12',
                'date' => 'required|date|after_or_equal:today',
                'time' => 'required|date_format:H:i:s', // Changed to match the actual format being sent
                'vehicle_id' => 'required|integer|exists:vehicles,id',
                'guider' => 'required|in:yes,no',
                'guider_id' => 'nullable|integer|exists:guiders,id',
                'total_price' => 'required|numeric|min:0',
                'status' => 'required|in:pending,confirmed,cancelled',
            ]);

            // Handle guider field based on guider_id
            if ($request->filled('guider_id')) {
                $validated['guider'] = 'yes';
            } else {
                $validated['guider'] = 'no';
            }

            // Update the booking
            $booking->update($validated);

            // Check if guider or vehicle actually changed
            $guiderChanged = $oldGuiderId != $booking->guider_id;
            $vehicleChanged = $oldVehicleId != $booking->vehicle_id;

            // Send emails if guider or vehicle changed
            if ($guiderChanged || $vehicleChanged) {
                // Reload the booking with relationships to get updated data
                $booking->load('guider', 'vehicle');
                $this->sendAssignmentEmails($booking, $oldGuiderId, $oldVehicleId);
            }

            return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating booking: ' . $e->getMessage())->withInput();
        }
    }

    private function sendAssignmentEmails($booking, $oldGuiderId = null, $oldVehicleId = null)
    {
        $userEmail = $booking->email;
        $guider = $booking->guider;
        $vehicle = $booking->vehicle;

        try {
            // Always email user on assignment/change
            if ($userEmail) {
                Mail::to($userEmail)->send(new BookingAssignmentMail($booking, $guider, $vehicle, 'user'));
            }

            // Email new guider if assigned/changed
            if ($booking->guider_id && $booking->guider_id != $oldGuiderId) {
                $newGuider = Guider::find($booking->guider_id);
                if ($newGuider && $newGuider->email) {
                    Mail::to($newGuider->email)->send(new BookingAssignmentMail($booking, $newGuider, $vehicle, 'guider'));
                }
            }
        } catch (\Exception $e) {
            // Log the error but don't stop the process
            \Log::error('Failed to send booking assignment emails: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully');
    }
}
