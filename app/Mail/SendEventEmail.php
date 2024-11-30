<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class SendEventEmail extends Mailable
{
    public $emailContent;

    /**
     * Constructor for the Mailable class.
     *
     * @param string $content The content of the email message.
     */
    public function __construct($content)
    {
        $this->emailContent = (string) $content; // Ensure it's always a string.
    }

    /**
     * Build the email with subject and view.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Event Update')
                    ->view('emails.event_notification')
                    ->with(['emailContent' => $this->emailContent]);
    }
}
