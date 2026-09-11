<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public string $statusLabel;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order->loadMissing(['items.menuItem', 'user']);
        $this->statusLabel = ucfirst($order->status);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '👑 NFC - Nawabi Food Corner - Order Receipt #' . $this->order->order_number . ' [' . $this->statusLabel . ']',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-receipt',
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
