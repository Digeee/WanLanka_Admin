<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomPackageAssignmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customPackage;
    public $user;
    public $guider;
    public $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customPackage, $user, $guider, $type)
    {
        $this->customPackage = $customPackage;
        $this->user = $user;
        $this->guider = $guider;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Custom Package Assignment Update')
                    ->view('emails.custom-package-assignment');
    }
}