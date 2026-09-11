<?php

namespace App\Filament\Widgets;

use App\Models\InternalNotification;
use App\Models\Order;
use Filament\Widgets\Widget;

class NotificationsWidget extends Widget
{
    protected static string $view = 'filament.widgets.notifications-widget';

    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = [
        'md' => 12,
        'xl' => 6,
    ];

    public function getNotifications()
    {
        return InternalNotification::where('is_read', false)
            ->whereIn('notifiable_role', ['all', 'admin'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function sendKitchenKOT(int $notificationId, int $orderId): void
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->update(['status' => 'preparing']);

            \Filament\Notifications\Notification::make()
                ->title("KOT Dispatched to Kitchen! 👨‍🍳")
                ->body("Order #{$order->order_number} is now being prepared.")
                ->success()
                ->send();
        }

        $notification = InternalNotification::find($notificationId);
        if ($notification) {
            $notification->update(['is_read' => true]);
        }
    }

    public function markAsRead(int $notificationId): void
    {
        $notification = InternalNotification::find($notificationId);
        if ($notification) {
            $notification->update(['is_read' => true]);
        }
    }
}
