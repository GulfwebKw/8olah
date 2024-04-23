<?php

namespace App\Mail;

use App\Models\Inbox;
use HackerESQ\Settings\Facades\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InboxEMail extends Mailable
{
    use Queueable, SerializesModels;

    public Inbox $inbox;
    /**
     * Create a new message instance.
     */
    public function __construct(Inbox $inbox)
    {
        $this->inbox = $inbox;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreplay@8olah.com'),
            subject: 'New Message From '.$this->inbox->user->company_name . ' ('.$this->inbox->user->name.')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            html: 'Hi,<br>You get new message from '.$this->inbox->user->company_name . ' ('.$this->inbox->user->name.')<br>Message:<br>'.$this->inbox->message,
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
