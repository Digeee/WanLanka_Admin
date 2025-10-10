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
    public $type;

    public function __construct($booking, $guider, $vehicle, $type)
    {
        $this->booking = $booking;
        $this->guider = $guider;
        $this->vehicle = $vehicle;
        $this->type = $type;
    }

    public function build()
    {
        return $this->subject('Booking Assignment Update')
                    ->view('emails.booking-assignment');
    }
}
