<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $replyMessage;

    /**
     * Create a new message instance.
     *
     * @param string $replyMessage
     */
    public function __construct($replyMessage)
    {
        $this->replyMessage = $replyMessage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reply to Your Contact Message')
            ->view('emails.contact_reply')
            ->with([
                'replyMessage' => $this->replyMessage,
            ]);
    }
}
