<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FixedBooking;
use App\Models\Package;
use App\Models\Vehicle;
use App\Models\Guider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\BookingAssignmentMail;

class FixedPackageBookingController extends Controller
{
    public function index()
    {
        // Get all fixed bookings
        $bookings = FixedBooking::with(['user', 'package'])->get()->map(function ($booking) {
            return [
                'id' => $booking->id,
                'package_name' => $booking->package_name ?? 'Unknown Package',
                'first_name' => $booking->first_name,
                'last_name' => $booking->last_name,
                'email' => $booking->email,
                'phone' => $booking->phone,
                'pickup_location' => $booking->pickup_location,
                'participants' => $booking->participants,
                'total_price' => number_format($booking->total_price, 2),
                'payment_method' => $booking->payment_method,
                'status' => $booking->status,
                'created_at' => $booking->created_at->format('Y-m-d H:i:s'),
            ];
        });
        return view('admin.bookings.fixedpackages_bookings.index', compact('bookings'));
    }

    public function edit($id)
    {
        $booking = FixedBooking::with(['user', 'package'])->findOrFail($id);
        $vehicles = Vehicle::all();
        $guiders = Guider::all();
        return view('admin.bookings.fixedpackages_bookings.edit', compact('booking', 'vehicles', 'guiders'));
    }

    public function update(Request $request, $id)
    {
        try {
            $booking = FixedBooking::findOrFail($id);

            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:255',
                'pickup_location' => 'required|string|max:255',
                'payment_method' => 'required|string|max:255',
                'receipt' => 'nullable|string|max:255',
                'participants' => 'required|integer|min:1',
                'total_price' => 'required|numeric|min:0',
                'status' => 'required|in:pending,confirmed,cancelled,completed',
                'vehicle_id' => 'nullable|exists:vehicles,id',
                'guider_id' => 'nullable|exists:guiders,id',
            ]);

            // Check if guider was assigned/unassigned
            $oldGuiderId = $booking->guider_id;
            $newGuiderId = $validated['guider_id'] ?? null;

            // Check if vehicle was assigned/unassigned
            $oldVehicleId = $booking->vehicle_id;
            $newVehicleId = $validated['vehicle_id'] ?? null;

            // Update the booking
            $booking->update($validated);

            // Send email notification if guider was assigned or changed
            if ($oldGuiderId != $newGuiderId) {
                Log::info('Sending guider assignment email for booking ID: ' . $booking->id);
                $this->sendGuiderAssignmentEmail($booking, $newGuiderId, $oldGuiderId, $newVehicleId);
            } else {
                Log::info('No guider change detected for booking ID: ' . $booking->id);
            }

            return redirect()->route('admin.fixedpackage.bookings.index')->with('success', 'Booking updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating booking: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating booking: ' . $e->getMessage())->withInput();
        }
    }

    private function sendGuiderAssignmentEmail($booking, $newGuiderId, $oldGuiderId, $vehicleId)
    {
        try {
            Log::info('Preparing to send emails for booking ID: ' . $booking->id);

            // Load the vehicle and guider models
            $vehicle = $vehicleId ? Vehicle::find($vehicleId) : null;
            $newGuider = $newGuiderId ? Guider::find($newGuiderId) : null;
            $oldGuider = $oldGuiderId ? Guider::find($oldGuiderId) : null;

            Log::info('Vehicle: ' . ($vehicle ? $vehicle->id : 'null'));
            Log::info('New Guider: ' . ($newGuider ? $newGuider->id : 'null'));
            Log::info('Old Guider: ' . ($oldGuider ? $oldGuider->id : 'null'));

            // Notify the user
            if ($booking->email) {
                Log::info('Sending email to user: ' . $booking->email);
                Mail::to($booking->email)->send(new BookingAssignmentMail($booking, $newGuider, $vehicle, 'user'));
                Log::info('Email sent to user successfully');
            }

            // Notify the new guider if assigned
            if ($newGuiderId && $newGuider && $newGuider->email) {
                Log::info('Sending email to new guider: ' . $newGuider->email);
                Mail::to($newGuider->email)->send(new BookingAssignmentMail($booking, $newGuider, $vehicle, 'guider'));
                Log::info('Email sent to new guider successfully');
            }

            // Notify the old guider if unassigned
            if ($oldGuiderId && $oldGuider && $oldGuider->email) {
                Log::info('Sending email to old guider: ' . $oldGuider->email);
                Mail::to($oldGuider->email)->send(new BookingAssignmentMail($booking, $oldGuider, $vehicle, 'unassigned'));
                Log::info('Email sent to old guider successfully');
            }

            Log::info('All emails processed for booking ID: ' . $booking->id);
        } catch (\Exception $e) {
            Log::error('Error sending booking assignment email: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
        }
    }

    public function destroy($id)
    {
        $booking = FixedBooking::findOrFail($id);
        $booking->delete();
        return redirect()->route('admin.fixedpackage.bookings.index')->with('success', 'Booking deleted successfully');
    }
}
