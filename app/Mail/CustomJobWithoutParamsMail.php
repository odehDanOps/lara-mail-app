<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomJobWithoutParamsMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * CustomMesCustomJobWithoutParamssage instance..
     *
     */
    public function __construct()
    {
        $this->subject = 'Hello'; # TODO: make dynamic
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.custom-message-without-params',
            with: [
                'subject' => $this->subject
            ],
        );
    }
}
