<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\FixedPackageBooking;

class FixedPackageBookingStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $recipientType;

    public function __construct(FixedPackageBooking $booking, $recipientType)
    {
        $this->booking = $booking;
        $this->recipientType = $recipientType;
    }

    public function build()
    {
        $subject = $this->recipientType === 'user'
            ? "Your Booking Status Updated - WanLanka"
            : "Booking Status Changed by Admin - WanLanka";

        return $this->subject($subject)
                    ->view('emails.fixed_booking_status_updated')
                    ->with([
                        'booking' => $this->booking,
                        'recipientType' => $this->recipientType,
                    ]);
    }
}
