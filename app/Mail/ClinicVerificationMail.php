<?php

namespace App\Mail;

use App\Models\Clinic;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClinicVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Clinic $clinic;

    public function __construct(Clinic $clinic)
    {
        $this->clinic = $clinic;
    }

    public function build()
    {
        return $this->subject('Clinic Verification')
            ->view('emails.clinic-verification');
    }
}