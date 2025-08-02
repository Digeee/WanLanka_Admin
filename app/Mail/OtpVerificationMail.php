<?php
// resources/Mail/OtpVerificationMail.php
namespace App\Mail;

use Illuminate\Mail\Mailable;

class OtpVerificationMail extends Mailable
{
    public $otp_token;

    public function __construct($otp_token)
    {
        $this->otp_token = $otp_token;
    }

    public function build()
    {
        return $this->view('emails.otp-verification')
                    ->with('otp_token', $this->otp_token);
    }
}
