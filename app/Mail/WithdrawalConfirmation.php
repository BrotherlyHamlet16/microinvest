<?php

namespace App\Mail;

use App\Models\Investment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WithdrawalConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $investment;
    public $total;
    /**
     * Create a new message instance.
     */
    public function __construct(Investment $investment, $total)
    {
        $this->investment = $investment;
        $this->total = $total;
    }


    public function build()
    {
        return $this->subject('Your Withdrawal Was Successful')
            ->markdown('emails.investment.withdrawal');
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Withdrawal Confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.investment.withdrawal',
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
