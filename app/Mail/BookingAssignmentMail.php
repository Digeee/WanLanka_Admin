<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingAssignmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $guider;
    public $vehicle;
    public $type; // 'user', 'guider', 'unassigned'

    public function __construct($booking, $guider = null, $vehicle = null, $type = 'user')
    {
        $this->booking = $booking;
        $this->guider = $guider;
        $this->vehicle = $vehicle;
        $this->type = $type;
    }

    public function build()
    {
        $subject = match ($this->type) {
            'guider' => 'New Booking Assigned to You',
            'unassigned' => 'Booking Unassigned',
            default => 'Your Booking Update',
        };

        return $this->subject($subject)
                    ->view('emails.booking-assignment')
                    ->with([
                        'booking' => $this->booking,
                        'guider' => $this->guider,
                        'vehicle' => $this->vehicle,
                        'type' => $this->type,
                    ]);
    }
}
