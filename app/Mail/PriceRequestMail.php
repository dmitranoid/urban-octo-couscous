<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PriceRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Message $msg
    )
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Price Request ' . $this->msg->code,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.price-request',
            with: ['msg' => $this->msg],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}