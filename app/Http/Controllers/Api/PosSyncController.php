<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PosSetting;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PosSyncController extends Controller
{
    /**
     * Health check and connectivity ping.
     */
    public function health(Request $request): JsonResponse
    {
        $token = $request->header('X-Terminal-Token') ?? $request->query('token');
        $terminal = null;
        if ($token) {
            $terminal = User::where('api_token', $token)->first();
        }

        return response()->json([
            'status' => 'online',
            'restaurant' => 'Nawabi Food Corner POS Cloud Hub',
            'server_time' => now()->toIso8601String(),
            'authenticated' => (bool)$terminal,
            'terminal_code' => $terminal?->terminal_code ?? 'ANONYMOUS',
            'version' => '2.0-hybrid',
        ]);
    }

    /**
     * Pull catalog delta, active waiter orders, and staff logins to local POS terminal.
     */
    public function pull(Request $request): JsonResponse
    {
        $lastSyncedAt = $request->input('last_synced_at');

        // 1. Categories
        $categoriesQuery = MenuCategory::query();
        if ($lastSyncedAt) {
            $categoriesQuery->where('updated_at', '>=', $lastSyncedAt);
        }
        $categories = $categoriesQuery->get(['id', 'name', 'slug', 'description', 'is_active', 'sort_order', 'updated_at']);

        // 2. Menu Items
        $itemsQuery = MenuItem::query();
        if ($lastSyncedAt) {
            $itemsQuery->where('updated_at', '>=', $lastSyncedAt);
        }
        $menuItems = $itemsQuery->get([
            'id', 'category_id', 'name', 'description', 'price', 
            'is_available', 'image_path', 'details', 'updated_at'
        ])->map(function ($item) {
            $arr = $item->toArray();
            $arr['resolved_image'] = $item->resolved_image;
            return $arr;
        });

        // 3. Settings (VAT, service charge, card terminal, branding)
        $settings = PosSetting::all()->pluck('value', 'key');

        // 4. Staff Accounts for Offline Login (Cashiers & Waiters)
        $staff = User::where('is_active', true)
            ->get(['id', 'name', 'email', 'role', 'pin', 'terminal_code', 'phone', 'password', 'updated_at']);

        // 5. Active Waiter Orders (orders placed on tables that are not yet completed)
        $activeWaiterOrders = Order::with('items.menuItem')
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'cancelled')
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get();

        return response()->json([
            'status' => 'success',
            'server_time' => now()->toIso8601String(),
            'categories' => $categories,
            'menu_items' => $menuItems,
            'settings' => $settings,
            'staff' => $staff,
            'active_waiter_orders' => $activeWaiterOrders,
        ]);
    }

    /**
     * Push offline-generated orders and transactions to the Cloud Server.
     */
    public function push(Request $request): JsonResponse
    {
        $ordersPayload = $request->input('orders', []);
        $terminalCode = $request->input('terminal_code', 'POS-01');

        if (!is_array($ordersPayload) || empty($ordersPayload)) {
            return response()->json([
                'status' => 'success',
                'message' => 'No orders in payload to sync',
                'synced_count' => 0,
                'synced_uuids' => [],
                'server_time' => now()->toIso8601String(),
            ]);
        }

        $syncedUuids = [];
        $errors = [];

        DB::beginTransaction();
        try {
            foreach ($ordersPayload as $orderData) {
                $uuid = $orderData['uuid'] ?? null;
                if (!$uuid) {
                    continue;
                }

                // Check if already synced previously
                $existing = Order::where('uuid', $uuid)->first();
                if ($existing) {
                    // Update existing order status if changed
                    $existing->update([
                        'status' => $orderData['status'] ?? $existing->status,
                        'payment_status' => $orderData['payment_status'] ?? $existing->payment_status,
                        'payment_method' => $orderData['payment_method'] ?? $existing->payment_method,
                        'transaction_reference' => $orderData['transaction_reference'] ?? $existing->transaction_reference,
                        'synced_at' => now(),
                    ]);
                    $syncedUuids[] = $uuid;
                    continue;
                }

                // Make sure order number doesn't collide with online orders
                $orderNumber = $orderData['order_number'] ?? null;
                if (!$orderNumber || Order::where('order_number', $orderNumber)->exists()) {
                    $orderNumber = ($orderData['terminal_code'] ?? $terminalCode) . '-' . strtoupper(substr(uniqid(), -6));
                }

                $order = Order::create([
                    'uuid' => $uuid,
                    'terminal_code' => $orderData['terminal_code'] ?? $terminalCode,
                    'user_id' => $orderData['user_id'] ?? null,
                    'waiter_id' => $orderData['waiter_id'] ?? null,
                    'order_number' => $orderNumber,
                    'table_number' => $orderData['table_number'] ?? null,
                    'customer_name' => $orderData['customer_name'] ?? 'Walk-In Guest',
                    'customer_phone' => $orderData['customer_phone'] ?? null,
                    'customer_address' => $orderData['customer_address'] ?? null,
                    'subtotal' => $orderData['subtotal'] ?? 0,
                    'tax' => $orderData['tax'] ?? 0,
                    'discount' => $orderData['discount'] ?? 0,
                    'total' => $orderData['total'] ?? 0,
                    'status' => $orderData['status'] ?? 'completed',
                    'payment_status' => $orderData['payment_status'] ?? 'paid',
                    'payment_method' => $orderData['payment_method'] ?? 'cash',
                    'transaction_reference' => $orderData['transaction_reference'] ?? null,
                    'type' => $orderData['type'] ?? 'dine_in',
                    'special_notes' => $orderData['special_notes'] ?? null,
                    'synced_at' => now(),
                    'created_at' => isset($orderData['created_at']) ? \Carbon\Carbon::parse($orderData['created_at']) : now(),
                ]);

                // Create Order Items
                if (isset($orderData['items']) && is_array($orderData['items'])) {
                    foreach ($orderData['items'] as $itemData) {
                        $price = $itemData['unit_price'] ?? ($itemData['price'] ?? 0);
                        $qty = $itemData['quantity'] ?? 1;
                        OrderItem::create([
                            'order_id' => $order->id,
                            'menu_item_id' => $itemData['menu_item_id'] ?? null,
                            'quantity' => $qty,
                            'unit_price' => $price,
                            'total_price' => $itemData['total_price'] ?? ($price * $qty),
                            'notes' => $itemData['notes'] ?? ($itemData['comment'] ?? null),
                        ]);
                    }
                }

                $syncedUuids[] = $uuid;
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('POS Sync Push Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process sync payload: ' . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'synced_count' => count($syncedUuids),
            'synced_uuids' => $syncedUuids,
            'server_time' => now()->toIso8601String(),
        ]);
    }
}
