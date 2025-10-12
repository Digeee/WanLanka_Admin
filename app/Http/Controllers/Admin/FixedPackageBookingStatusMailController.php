<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FixedPackageBooking;
use App\Mail\FixedPackageBookingStatusUpdatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FixedPackageBookingStatusMailController extends Controller
{
    public function index()
    {
        $bookings = FixedPackageBooking::all();
        return view('admin.bookings.fixedpackages_bookings.index', compact('bookings'));
    }

    public function edit($id)
    {
        $booking = FixedPackageBooking::findOrFail($id);
        return view('admin.bookings.fixedpackages_bookings.edit', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $booking = FixedPackageBooking::findOrFail($id);
        $oldStatus = $booking->status;

        $booking->update($request->all());

        if ($oldStatus !== $booking->status) {

    try {
        if (!empty($booking->email)) {
            Mail::to($booking->email)
                ->send(new FixedPackageBookingStatusUpdatedMail($booking, 'user'));
        }

        if (Auth::guard('admin')->check()) {
            $adminEmail = Auth::guard('admin')->user()->email;
            Mail::to($adminEmail)
                ->send(new FixedPackageBookingStatusUpdatedMail($booking, 'admin'));
        }
    } catch (\Exception $e) {
        Log::error("Email sending failed: " . $e->getMessage());
    }
}


        return redirect()
            ->route('admin.fixedpackage.bookings.index')
            ->with('success', 'Booking updated successfully. Emails sent to user and admin.');
    }

    public function destroy($id)
    {
        $booking = FixedPackageBooking::findOrFail($id);
        $booking->delete();

        return redirect()
            ->route('admin.fixedpackage.bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }
}
