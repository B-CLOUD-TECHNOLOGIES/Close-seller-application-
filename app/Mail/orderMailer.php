<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class orderMailer extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * Create a new message instance.
     */
    public $subject, $body, $getOrder, $orderItems, $createdAt;

    public function __construct($subject, $body, $getOrder = null, $orderItems = [], $createdAt = null)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->getOrder = $getOrder;
        $this->orderItems = $orderItems;
        $this->createdAt = $createdAt;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.orderMailer',
            with: [
                'subjectText' => $this->subject,
                'body' => $this->body,
                'getOrder' => $this->getOrder,
                'orderItems' => $this->orderItems,
                'createdAt' => $this->createdAt,
            ],
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
