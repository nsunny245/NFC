<?php

namespace App\Filament\Waiter\Pages;

use App\Models\MenuItem;
use App\Models\MenuCategory;
use App\Models\Order;
use App\Models\OrderItem;
use Filament\Pages\Page;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class WaiterDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.waiter.pages.waiter-dashboard';

    protected static ?string $title = 'Serving Waiter Table Pad';

    // Override the route path so it loads immediately at /waiter
    public static function getRoutePath(): string
    {
        return '/';
    }

    // Waiter Pad State
    public $search = '';
    public $selectedCategoryId = null;
    public $dealFilter = null; // null, 'deals', 'platters'
    public $activeSection = 'all'; // 'all', 'main_dining', 'family_hall', 'outdoor_dera'
    public $currentTab = 'tables'; // 'tables', 'order', 'alerts', 'shift'
    public $cartDrawerOpen = false;
    public $categoryModalOpen = false;
    
    public $selectedTable = null;
    public $cart = [];
    public $specialNotes = '';
    public $customerName = '';
    public $customerPhone = '';
    
    public $activeOrderId = null;

    public $portionSelectionModalOpen = false;
    public $portionModalItemId = null;

    public function getTitle(): string
    {
        return '';
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    public function openCategoryModal(): void
    {
        $this->categoryModalOpen = true;
    }

    public function closeCategoryModal(): void
    {
        $this->categoryModalOpen = false;
    }

    public function openPortionModal(int $itemId): void
    {
        $this->portionModalItemId = $itemId;
        $this->portionSelectionModalOpen = true;
    }

    public function closePortionModal(): void
    {
        $this->portionSelectionModalOpen = false;
        $this->portionModalItemId = null;
    }

    public function filterDeals(): void
    {
        $this->dealFilter = ($this->dealFilter === 'deals') ? null : 'deals';
        $this->selectedCategoryId = null;
        $this->categoryModalOpen = false;
    }

    public function filterPlatters(): void
    {
        $this->dealFilter = ($this->dealFilter === 'platters') ? null : 'platters';
        $this->selectedCategoryId = null;
        $this->categoryModalOpen = false;
    }

    public function resetFilters(): void
    {
        $this->dealFilter = null;
        $this->selectedCategoryId = null;
        $this->search = '';
        $this->categoryModalOpen = false;
    }

    public function getActiveCategoryNameProperty(): string
    {
        if ($this->dealFilter === 'deals') {
            return '🎁 All Deals & Combos';
        }
        if ($this->dealFilter === 'platters') {
            return '🍱 Platters & Feasts';
        }
        if (!$this->selectedCategoryId) {
            return 'All Menu Items';
        }
        return MenuCategory::find($this->selectedCategoryId)?->name ?? 'All Menu Items';
    }

    /**
     * Switch bottom app tab.
     */
    public function setTab(string $tab): void
    {
        $this->currentTab = $tab;
    }

    /**
     * Mobile cart drawer controls.
     */
    public function toggleCartDrawer(): void
    {
        $this->cartDrawerOpen = !$this->cartDrawerOpen;
    }

    public function openCartDrawer(): void
    {
        $this->cartDrawerOpen = true;
    }

    public function closeCartDrawer(): void
    {
        $this->cartDrawerOpen = false;
    }

    /**
     * Switch active dining floor zone filter.
     */
    public function setSection(string $section): void
    {
        $this->activeSection = $section;
    }

    /**
     * Toggle a common quick kitchen note for the overall order.
     */
    public function toggleQuickNote(string $note): void
    {
        $current = trim($this->specialNotes);
        if (str_contains($current, $note)) {
            $parts = array_map('trim', explode(',', $current));
            $parts = array_filter($parts, fn($p) => $p !== $note && !empty($p));
            $this->specialNotes = implode(', ', $parts);
        } else {
            $this->specialNotes = empty($current) ? $note : ($current . ', ' . $note);
        }
    }

    /**
     * Toggle a common quick kitchen note on a specific cart dish.
     */
    public function toggleItemQuickNote($cartKey, string $note): void
    {
        $key = (string)$cartKey;
        if (isset($this->cart[$key])) {
            $current = trim($this->cart[$key]['comment'] ?? '');
            if (str_contains($current, $note)) {
                $parts = array_map('trim', explode(',', $current));
                $parts = array_filter($parts, fn($p) => $p !== $note && !empty($p));
                $this->cart[$key]['comment'] = implode(', ', $parts);
            } else {
                $this->cart[$key]['comment'] = empty($current) ? $note : ($current . ', ' . $note);
            }
        }
    }

    public function getCartCountProperty(): int
    {
        return array_sum(array_column($this->cart, 'quantity'));
    }

    public function getCartTotalProperty(): float
    {
        $total = 0;
        foreach ($this->cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    /**
     * Add dish to active table cart (with optional portion/size).
     */
    public function addToCart(int $itemId, ?string $sizeKey = null): void
    {
        $item = MenuItem::find($itemId);
        if (!$item) return;

        $price = (float)$item->price;
        $name = $item->name;
        $sizeLabel = null;

        if ($sizeKey && isset($item->details['sizes'][$sizeKey])) {
            $sizeData = $item->details['sizes'][$sizeKey];
            if (is_array($sizeData)) {
                $price = (float)($sizeData['price'] ?? $item->price);
                $sizeLabel = $sizeData['label'] ?? ucfirst($sizeKey);
            } else {
                $price = (float)$sizeData;
                $sizeLabel = ucfirst($sizeKey);
            }
            $name .= " (" . $sizeLabel . ")";
        }

        // Keep integer-like key if no size to maintain 100% compatibility with existing tests
        $cartKey = $sizeKey ? ($itemId . '_' . $sizeKey) : $itemId;

        if (isset($this->cart[$cartKey])) {
            $this->cart[$cartKey]['quantity']++;
        } else {
            $this->cart[$cartKey] = [
                'id' => $item->id,
                'cart_key' => $cartKey,
                'name' => $name,
                'description' => $item->description ?? '',
                'price' => $price,
                'quantity' => 1,
                'size_key' => $sizeKey,
                'size_label' => $sizeLabel,
                'comment' => '',
            ];
        }

        // Close portion modal if open
        $this->portionSelectionModalOpen = false;
        $this->portionModalItemId = null;
    }

    /**
     * Update quantity of item in table cart.
     */
    public function updateQuantity($cartKey, int $qty): void
    {
        if (isset($this->cart[$cartKey])) {
            if ($qty <= 0) {
                unset($this->cart[$cartKey]);
            } else {
                $this->cart[$cartKey]['quantity'] = $qty;
            }
        }
    }

    /**
     * Remove item entirely from table cart.
     */
    public function removeFromCart($cartKey): void
    {
        if (isset($this->cart[$cartKey])) {
            unset($this->cart[$cartKey]);
        }
    }

    /**
     * Update kitchen note comment on an item in the table cart.
     */
    public function updateItemComment($cartKey, string $comment): void
    {
        if (isset($this->cart[$cartKey])) {
            $this->cart[$cartKey]['comment'] = $comment;
        }
    }

    /**
     * Switch selected menu category filter.
     */
    public function selectCategory(?int $categoryId = null): void
    {
        $this->dealFilter = null;
        $this->selectedCategoryId = $categoryId;
        $this->categoryModalOpen = false;
    }

    /**
     * Load an active dining session for the selected table!
     */
    public function selectTableForFeast(string $tableId): void
    {
        $this->selectedTable = $tableId;
        $this->currentTab = 'order';
        $this->cartDrawerOpen = false;

        // Check if there is an active dining order for this table
        $order = Order::where(function($q) use ($tableId) {
                $q->where('table_number', $tableId)
                  ->orWhere('table_number', 'Table ' . $tableId);
            })
            ->whereIn('status', ['pending', 'preparing', 'ready'])
            ->latest('id')
            ->first();

        if ($order) {
            $this->activeOrderId = $order->id;
            $this->specialNotes = $order->special_notes ?? '';
            $this->customerName = $order->customer_name ?? '';
            $this->customerPhone = $order->customer_phone ?? '';

            // Load items with portion size detection
            $this->cart = [];
            foreach ($order->items as $item) {
                $sizeKey = null;
                $sizeLabel = null;
                $menuItem = $item->menuItem;
                if ($menuItem && isset($menuItem->details['sizes']) && is_array($menuItem->details['sizes'])) {
                    foreach ($menuItem->details['sizes'] as $sKey => $sVal) {
                        $sPrice = is_array($sVal) ? (float)($sVal['price'] ?? 0) : (float)$sVal;
                        $sLabel = is_array($sVal) ? ($sVal['label'] ?? ucfirst($sKey)) : ucfirst($sKey);
                        if (abs($sPrice - (float)$item->unit_price) < 0.01) {
                            $sizeKey = $sKey;
                            $sizeLabel = $sLabel;
                            break;
                        }
                    }
                }

                $cartKey = $sizeKey ? ($item->menu_item_id . '_' . $sizeKey) : $item->menu_item_id;

                $this->cart[$cartKey] = [
                    'id' => $item->menu_item_id,
                    'cart_key' => $cartKey,
                    'name' => ($item->menuItem->name ?? 'Unknown Dish') . ($sizeLabel ? " (" . $sizeLabel . ")" : ''),
                    'description' => $item->menuItem->description ?? '',
                    'price' => (float)$item->unit_price,
                    'quantity' => $item->quantity,
                    'size_key' => $sizeKey,
                    'size_label' => $sizeLabel,
                    'comment' => $item->notes ?? '',
                ];
            }
        } else {
            // New order for this table
            $this->cart = [];
            $this->specialNotes = '';
            $this->customerName = '';
            $this->customerPhone = '';
            $this->activeOrderId = null;
        }

        \Filament\Notifications\Notification::make()
            ->title("Table Seating: {$tableId}")
            ->info()
            ->send();
    }

    /**
     * Clear and reset table selection.
     */
    public function deselectTable(): void
    {
        $this->selectedTable = null;
        $this->cart = [];
        $this->specialNotes = '';
        $this->customerName = '';
        $this->customerPhone = '';
        $this->activeOrderId = null;
        $this->currentTab = 'tables';
        $this->cartDrawerOpen = false;
    }

    /**
     * Get real-time shift performance statistics for this server.
     */
    public function getShiftStatsProperty(): array
    {
        $waiterId = \Filament\Facades\Filament::auth()->id() ?? Auth::id();
        $recentOrders = Order::where(function($q) use ($waiterId) {
                $q->where('waiter_id', $waiterId)
                  ->orWhere('user_id', $waiterId);
            })
            ->where('created_at', '>=', now()->subHours(24))
            ->get();

        $activeFloorTables = Order::where('type', 'dine_in')
            ->whereIn('status', ['pending', 'preparing', 'ready'])
            ->distinct('table_number')
            ->count('table_number');

        $currentUser = \Filament\Facades\Filament::auth()->user() ?? Auth::user();

        return [
            'total_orders' => $recentOrders->count(),
            'total_sales' => (float)$recentOrders->where('status', 'completed')->sum('total'),
            'active_orders' => $activeFloorTables,
            'server_name' => $currentUser->name ?? 'Floor Server',
        ];
    }

    /**
     * Get real-time active kitchen orders for tables (in process & ready).
     */
    public function getKitchenOrdersProperty()
    {
        return Order::with(['items.menuItem', 'user'])
            ->whereIn('status', ['pending', 'preparing', 'ready'])
            ->where('type', 'dine_in')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get recent completed orders for this shift.
     */
    public function getCompletedOrdersProperty()
    {
        $waiterId = \Filament\Facades\Filament::auth()->id() ?? Auth::id();
        return Order::with(['items.menuItem'])
            ->where('status', 'completed')
            ->where(function($q) use ($waiterId) {
                $q->where('waiter_id', $waiterId)
                  ->orWhere('user_id', $waiterId);
            })
            ->where('created_at', '>=', now()->subHours(24))
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
    }

    /**
     * Save/Append items to table order and dispatch KOT to Cashier!
     */
    public function sendToKitchen(): void
    {
        $this->validate([
            'cart' => 'required|array|min:1',
            'selectedTable' => 'required',
        ], [
            'cart.required' => 'Cannot dispatch an empty order to the kitchen.',
        ]);

        // Recalculate totals
        $subtotal = 0;
        foreach ($this->cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $isVatEnabled = \App\Models\PosSetting::isVatEnabled();
        $vatRate = \App\Models\PosSetting::getVatPercentage();
        $tax = $isVatEnabled ? ($subtotal * ($vatRate / 100)) : 0;
        $total = $subtotal + $tax;

        if ($this->activeOrderId) {
            $order = Order::find($this->activeOrderId);
            $order->update([
                'customer_name' => $this->customerName ?: null,
                'customer_phone' => $this->customerPhone ?: null,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'status' => 'preparing',
                'special_notes' => $this->specialNotes ?: null,
            ]);

            // Clear old items and recreate
            $order->items()->delete();
        } else {
            $order = Order::create([
                'user_id' => \Filament\Facades\Filament::auth()->id() ?? Auth::id(),
                'waiter_id' => \Filament\Facades\Filament::auth()->id() ?? Auth::id(),
                'order_number' => 'ND-POS-' . strtoupper(bin2hex(random_bytes(3))),
                'customer_name' => $this->customerName ?: null,
                'customer_phone' => $this->customerPhone ?: null,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'status' => 'preparing',
                'type' => 'dine_in',
                'table_number' => $this->selectedTable,
                'payment_status' => 'pending',
                'special_notes' => $this->specialNotes ?: null,
            ]);
            $this->activeOrderId = $order->id;
        }

        // Add items
        foreach ($this->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'total_price' => $item['price'] * $item['quantity'],
                'notes' => $item['comment'] ?: null,
            ]);
        }

        // Dispatch internal alert to POS Cashier monitor
        \App\Models\InternalNotification::create([
            'type' => 'new_kot',
            'title' => '🍳 New Waiter KOT: Table ' . $order->table_number,
            'message' => "Order #{$order->order_number} sent to kitchen by " . (\Filament\Facades\Filament::auth()->user()?->name ?? Auth::user()?->name ?? 'Waiter'),
            'notifiable_role' => 'cashier',
            'related_id' => $order->id,
        ]);

        \Filament\Notifications\Notification::make()
            ->title('KOT Dispatched to Kitchen! 🍳')
            ->body("Table {$this->selectedTable} order synced. Kitchen cooking queue updated.")
            ->success()
            ->send();

        // Deselect table and return to floor map
        $this->deselectTable();
    }

    /**
     * Hold / Park draft order for the active table without sending KOT to kitchen yet.
     */
    public function holdOrder(): void
    {
        $this->validate([
            'cart' => 'required|array|min:1',
            'selectedTable' => 'required',
        ], [
            'cart.required' => 'Cannot hold an empty table cart.',
        ]);

        // Recalculate totals
        $subtotal = 0;
        foreach ($this->cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $isVatEnabled = \App\Models\PosSetting::isVatEnabled();
        $vatRate = \App\Models\PosSetting::getVatPercentage();
        $tax = $isVatEnabled ? ($subtotal * ($vatRate / 100)) : 0;
        $total = $subtotal + $tax;

        if ($this->activeOrderId) {
            $order = Order::find($this->activeOrderId);
            $order->update([
                'customer_name' => $this->customerName ?: null,
                'customer_phone' => $this->customerPhone ?: null,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'status' => 'pending',
                'special_notes' => $this->specialNotes ?: null,
            ]);

            // Clear old items and recreate
            $order->items()->delete();
        } else {
            $order = Order::create([
                'user_id' => \Filament\Facades\Filament::auth()->id() ?? Auth::id(),
                'waiter_id' => \Filament\Facades\Filament::auth()->id() ?? Auth::id(),
                'order_number' => 'ND-POS-' . strtoupper(bin2hex(random_bytes(3))),
                'customer_name' => $this->customerName ?: null,
                'customer_phone' => $this->customerPhone ?: null,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'status' => 'pending',
                'type' => 'dine_in',
                'table_number' => $this->selectedTable,
                'payment_status' => 'pending',
                'special_notes' => $this->specialNotes ?: null,
            ]);
            $this->activeOrderId = $order->id;
        }

        // Add items
        foreach ($this->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'total_price' => $item['price'] * $item['quantity'],
                'notes' => $item['comment'] ?: null,
            ]);
        }

        \Filament\Notifications\Notification::make()
            ->title("Table {$this->selectedTable} Order Put on Hold ⏸️")
            ->body("Draft saved. Tap this table anytime to resume or dispatch KOT.")
            ->warning()
            ->send();

        // Deselect table and return to floor map
        $this->deselectTable();
    }

    /**
     * Get dynamic categories and menu items.
     */
    public function getCategoriesProperty()
    {
        return MenuCategory::withCount('menuItems')->get();
    }

    public function getMenuItemsProperty()
    {
        $query = MenuItem::with('category')->where('is_available', true);

        if ($this->dealFilter === 'deals') {
            $query->where(function($q) {
                $q->whereHas('category', function($cq) {
                    $cq->where('name', 'like', '%deal%');
                })->orWhere('name', 'like', '%deal%');
            });
        } elseif ($this->dealFilter === 'platters') {
            $query->where(function($q) {
                $q->whereHas('category', function($cq) {
                    $cq->where('name', 'like', '%platter%');
                })->orWhere('name', 'like', '%platter%');
            });
        } elseif ($this->selectedCategoryId) {
            $query->where('category_id', $this->selectedCategoryId);
        }

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        return $query->get();
    }

    /**
     * Get floor seating occupancy list.
     */
    public function getTablesProperty(): array
    {
        $tablesList = [];
        foreach (\App\Filament\Pages\SeatingMap::SECTIONS as $sectionKey => $section) {
            foreach ($section['tables'] as $table) {
                // Check if this table has an active dining order (pending, preparing, or ready)
                $activeOrder = Order::where(function($q) use ($table) {
                        $q->where('table_number', $table['id'])
                          ->orWhere('table_number', 'Table ' . $table['id']);
                    })
                    ->whereIn('status', ['pending', 'preparing', 'ready'])
                    ->latest()
                    ->first();

                $tablesList[] = [
                    'id' => $table['id'],
                    'capacity' => $table['capacity'],
                    'section' => $section['name'],
                    'section_key' => $sectionKey,
                    'status' => $activeOrder ? 'occupied' : 'vacant',
                    'order_id' => $activeOrder?->id,
                    'order_number' => $activeOrder?->order_number,
                    'order_status' => $activeOrder?->status,
                    'order_total' => $activeOrder?->total,
                    'items_count' => $activeOrder ? $activeOrder->items()->count() : 0,
                    'elapsed_mins' => $activeOrder ? (int) $activeOrder->created_at->diffInMinutes(now()) : 0,
                    'bill_requested' => (bool) ($activeOrder?->bill_requested),
                ];
            }
        }
        return $tablesList;
    }

    /**
     * Get unread ready-to-serve notifications for serving waiters.
     */
    public function getServingNotificationsProperty()
    {
        return \App\Models\InternalNotification::where('is_read', false)
            ->where('notifiable_role', 'waiter')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Mark a serving notification as read (food served to table).
     */
    public function dismissServingNotification(int $notificationId): void
    {
        $notification = \App\Models\InternalNotification::find($notificationId);
        if ($notification) {
            $notification->update(['is_read' => true]);

            if ($notification->related_id) {
                Order::where('id', $notification->related_id)->update(['served_at' => now()]);
            }

            \Filament\Notifications\Notification::make()
                ->title("Order Marked as Served! 🍽️")
                ->body("Status updated successfully on the serving pad.")
                ->success()
                ->send();
        }
    }

    /**
     * Waiter sends request to Cashier POS to settle the bill for table.
     */
    public function requestBillSettlement(?int $orderId = null): void
    {
        $id = $orderId ?? $this->activeOrderId;
        if (!$id && $this->selectedTable) {
            $tableId = $this->selectedTable;
            $order = Order::where(function($q) use ($tableId) {
                    $q->where('table_number', $tableId)
                      ->orWhere('table_number', 'Table ' . $tableId);
                })
                ->whereIn('status', ['pending', 'preparing', 'ready'])
                ->latest('id')
                ->first();
            $id = $order?->id;
        }

        if (!$id) {
            return;
        }

        $order = Order::find($id);
        if (!$order) {
            return;
        }

        $order->update([
            'bill_requested' => true,
            'bill_requested_at' => now(),
        ]);

        $waiterName = \Filament\Facades\Filament::auth()->user()?->name ?? 'Waiter Staff';
        $tableNum = $order->table_number ?: 'Table';
        $tableDisplay = str_starts_with($tableNum, 'Table') ? $tableNum : "Table {$tableNum}";

        \App\Models\InternalNotification::create([
            'type' => 'bill_requested',
            'title' => "🧾 Bill Requested: {$tableDisplay}",
            'message' => "Waiter {$waiterName} requested bill settlement for {$tableDisplay} (Order #{$order->order_number}). Total: Rs. " . number_format($order->total, 0),
            'notifiable_role' => 'cashier',
            'related_id' => $order->id,
        ]);

        \Filament\Notifications\Notification::make()
            ->title("Bill Settlement Requested! 🧾")
            ->body("Cashier alerted to prepare & settle bill for {$tableDisplay}.")
            ->success()
            ->send();
    }
}
