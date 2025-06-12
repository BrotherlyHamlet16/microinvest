<?php

namespace App\Mail;

use App\Models\Investment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvestmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $investment;
    /**
     * Create a new message instance.
     */
    public function __construct(Investment $investment)
    {
        $this->investment = $investment;
    }

    public function build()
    {
        return $this->subject('Your Investment is Confirmed!')
            ->markdown('emails.investment.confirmation');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Investment Confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.investment.confirmation',
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
