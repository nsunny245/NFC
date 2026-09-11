<?php

namespace App\Observers;

use App\Models\Order;
use App\Services\NotificationService;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param Order $order
     * @return void
     */
    public function created(Order $order): void
    {
        app(NotificationService::class)->dispatchOrderNotification($order);

        if ($order->status === 'completed') {
            $this->depleteStock($order);
        }
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param Order $order
     * @return void
     */
    public function updated(Order $order): void
    {
        if ($order->isDirty('status')) {
            app(NotificationService::class)->dispatchOrderNotification($order);

            if ($order->status === 'completed') {
                $this->depleteStock($order);
            }
        }
    }

    /**
     * Automatically deplete inventory items based on MenuItem recipe mappings.
     */
    protected function depleteStock(Order $order): void
    {
        $order->load(['items.menuItem.recipeItems.inventoryItem']);

        foreach ($order->items as $orderItem) {
            $menuItem = $orderItem->menuItem;
            if ($menuItem && $menuItem->recipeItems->isNotEmpty()) {
                foreach ($menuItem->recipeItems as $recipeItem) {
                    $inventoryItem = $recipeItem->inventoryItem;
                    if ($inventoryItem) {
                        $qtyToSubtract = (float)$recipeItem->required_quantity * (int)$orderItem->quantity;
                        $inventoryItem->decrement('quantity', $qtyToSubtract);
                    }
                }
            }
        }
    }
}
