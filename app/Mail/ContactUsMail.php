<?php

namespace App\Mail;

use App\Models\Message as InfoMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public InfoMessage $msg
    )
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contact Us',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-us',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}