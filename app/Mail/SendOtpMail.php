<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;   // public để view truy cập

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mã OTP của bạn',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.otp',   // ← phải khớp với file blade
        );
    }
}