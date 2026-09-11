<?php

namespace App\Observers;

use App\Models\Reservation;
use App\Services\NotificationService;

class ReservationObserver
{
    /**
     * Handle the Reservation "created" event.
     *
     * @param Reservation $reservation
     * @return void
     */
    public function created(Reservation $reservation): void
    {
        app(NotificationService::class)->dispatchReservationNotification($reservation);
    }

    /**
     * Handle the Reservation "updated" event.
     *
     * @param Reservation $reservation
     * @return void
     */
    public function updated(Reservation $reservation): void
    {
        if ($reservation->isDirty('status')) {
            app(NotificationService::class)->dispatchReservationNotification($reservation);
        }
    }
}
