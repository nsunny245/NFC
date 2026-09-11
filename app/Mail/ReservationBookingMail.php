<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    public Reservation $reservation;
    public string $statusLabel;

    /**
     * Create a new message instance.
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
        $this->statusLabel = ucfirst($reservation->status);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '👑 NFC - Nawabi Food Corner - Reservation Update: ' . $this->statusLabel,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation-booking',
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
