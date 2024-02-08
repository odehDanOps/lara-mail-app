<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomMessageMail extends Mailable
{
    use Queueable, SerializesModels;

     /**
     * CustomMessage instance..
     *
     * @param $name
     * @param $email
     * @param $mobileNumber
     * @param $placeOfAssignment
     */
    public function __construct($name, $email, $mobileNumber, $placeOfAssignment)
    {
        $this->name = $name;
        $this->email = $email;
        $this->mobileNumber = $mobileNumber;
        $this->placeOfAssignment = $placeOfAssignment;
        $this->subject = 'Zoom Meeting';
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.custom-message',
            with: [
                'name' => $this->name,
                'subject' => $this->subject
            ],
        );
    }
}
