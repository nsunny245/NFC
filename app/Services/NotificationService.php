<?php

namespace App\Services;

use App\Mail\ReservationBookingMail;
use App\Mail\OrderReceiptMail;
use App\Models\Reservation;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    protected SmsService $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Dispatch email & SMS notifications for a table reservation update.
     *
     * @param Reservation $reservation
     * @return void
     */
    public function dispatchReservationNotification(Reservation $reservation): void
    {
        // 1. Send SMS Notification
        $this->sendReservationSms($reservation);

        // 2. Send HTML Email Notification if guest email is present
        if (!empty($reservation->guest_email)) {
            try {
                Mail::to($reservation->guest_email)->send(new ReservationBookingMail($reservation));
                Log::info("Reservation email sent successfully to {$reservation->guest_email} for reservation ID {$reservation->id}.");
            } catch (\Exception $e) {
                Log::error("Failed to send reservation email to {$reservation->guest_email}: " . $e->getMessage());
            }
        } else {
            Log::info("No guest email provided for reservation ID {$reservation->id}, skipping email dispatch.");
        }
    }

    /**
     * Dispatch email & SMS notifications for an order status update.
     *
     * @param Order $order
     * @return void
     */
    public function dispatchOrderNotification(Order $order): void
    {
        // 1. Send SMS Notification
        $this->sendOrderSms($order);

        // 2. Send HTML Email Receipt if user has an email
        $recipientEmail = $order->user?->email;
        if (!empty($recipientEmail)) {
            try {
                Mail::to($recipientEmail)->send(new OrderReceiptMail($order));
                Log::info("Order status update email sent successfully to {$recipientEmail} for order #{$order->order_number}.");
            } catch (\Exception $e) {
                Log::error("Failed to send order email to {$recipientEmail}: " . $e->getMessage());
            }
        } else {
            Log::info("No user email found for order #{$order->order_number}, skipping email dispatch.");
        }
    }

    /**
     * Build and send the reservation SMS based on status.
     *
     * @param Reservation $reservation
     * @return void
     */
    protected function sendReservationSms(Reservation $reservation): void
    {
        $name = $reservation->guest_name;
        $count = $reservation->guest_count;
        $time = $reservation->reservation_time->format('M d, Y \a\t h:i A');
        $table = $reservation->table_number ?: 'TBD';
        $status = strtoupper($reservation->status);

        $smsMessage = match ($reservation->status) {
            'confirmed' => "👑 Dear {$name}, your NFC - Nawabi Food Corner reservation for {$count} guests on {$time} is CONFIRMED! Table: {$table}. We await your royal presence.",
            'seated' => "Welcome to NFC - Nawabi Food Corner, {$name}! Your group of {$count} has been seated at Table: {$table}. Have a royal dining experience!",
            'cancelled' => "Dear {$name}, we regret to inform you that your NFC - Nawabi Food Corner reservation for {$time} has been CANCELLED. We hope to host you another time.",
            default => "Greetings {$name}, your table reservation for {$count} guests on {$time} has been received. Status: {$status}. We will contact you shortly.",
        };

        if (!empty($reservation->guest_phone)) {
            $this->smsService->send($reservation->guest_phone, $smsMessage);
        } else {
            Log::warning("No guest phone number listed for reservation ID {$reservation->id}. SMS message would have been: \"{$smsMessage}\"");
        }
    }

    /**
     * Build and send the order SMS based on status.
     *
     * @param Order $order
     * @return void
     */
    protected function sendOrderSms(Order $order): void
    {
        $orderNum = $order->order_number;
        $total = number_format($order->total, 0);
        $typeLabel = str_replace('_', ' ', $order->type);
        $status = strtoupper($order->status);

        $smsMessage = match ($order->status) {
            'pending' => "Your NFC - Nawabi Food Corner order #{$orderNum} has been received. Total: Rs. {$total}. Status: {$status}. We are reviewing it now.",
            'preparing' => "👑 NFC: Order #{$orderNum} is now PREPARING. Our culinary artists are crafting your royal meal.",
            'ready' => "🎉 Great news! Your NFC order #{$orderNum} is READY for " . strtoupper($typeLabel) . "! Enjoy your royal feast.",
            'completed' => "Thank you for choosing NFC - Nawabi Food Corner! Order #{$orderNum} has been COMPLETED. We hope your experience was royal.",
            'cancelled' => "Notice: Your NFC order #{$orderNum} has been CANCELLED. Please contact us at 0311-8484987 for details or support.",
            default => "Your NFC - Nawabi Food Corner order #{$orderNum} has updated to {$status}. Total: Rs. {$total}.",
        };

        // Get recipient phone number: use user's phone if present, otherwise log it
        $phone = null;
        if ($order->user && isset($order->user->phone)) {
            $phone = $order->user->phone;
        }

        if (!empty($phone)) {
            $this->smsService->send($phone, $smsMessage);
        } else {
            // Log for mock order SMS since users don't have phone column in schema
            Log::info("👑 Order SMS Mock (No User Phone Available) 👑\nOrder: #{$orderNum}\nMessage: \"{$smsMessage}\"\n----------------------------");
        }
    }
}
