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
        return view('admin.bookings.fixedpackages_bookings.edit', compact('booking'));
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
            ]);

            // Update the booking
            $booking->update($validated);

            return redirect()->route('admin.fixedpackage.bookings.index')->with('success', 'Booking updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating booking: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $booking = FixedBooking::findOrFail($id);
        $booking->delete();
        return redirect()->route('admin.fixedpackage.bookings.index')->with('success', 'Booking deleted successfully');
    }
}