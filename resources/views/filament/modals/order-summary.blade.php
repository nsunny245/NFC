<div class="space-y-4 p-2 font-sans">
    <style>
        .nfc-modal-box-inner {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }
        .dark .nfc-modal-box-inner {
            background: #0f172a !important;
            border-color: #334155 !important;
        }
        .nfc-modal-table-th {
            background: #f1f5f9;
            color: #334155;
        }
        .dark .nfc-modal-table-th {
            background: #0f172a !important;
            color: #cbd5e1 !important;
        }
    </style>

    <!-- Header banner -->
    <div class="text-center pb-3 border-b border-gray-200 dark:border-gray-700">
        <div class="text-xl font-black text-amber-600 dark:text-amber-400 tracking-tight flex items-center justify-center gap-2">
            <span>👑</span>
            <span>NAWABI DERA</span>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400">Royal Food Corner • Okara Cantt</p>
        <div class="mt-2 inline-flex items-center gap-2 px-3 py-1 bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300 rounded-full font-mono text-xs font-bold border border-amber-200 dark:border-amber-800">
            <span>Order #{{ $order->order_number }}</span>
            <span>•</span>
            <span>{{ $order->created_at ? $order->created_at->format('M d, Y h:i A') : 'N/A' }}</span>
        </div>
    </div>

    <!-- Customer & Service Overview -->
    <div class="grid grid-cols-2 gap-3 text-xs nfc-modal-box-inner p-3 rounded-xl">
        <div>
            <div class="text-gray-500 dark:text-gray-400 font-medium">Customer / Guest</div>
            <div class="font-bold text-gray-900 dark:text-gray-100 text-sm mt-0.5">
                {{ $order->customer_name ?: 'Walk-in Guest 👤' }}
            </div>
            @if($order->customer_phone)
                <div class="text-gray-600 dark:text-gray-300 font-mono mt-0.5">📞 {{ $order->customer_phone }}</div>
            @endif
            @if($order->customer_address)
                <div class="text-gray-600 dark:text-gray-300 mt-1">📍 {{ $order->customer_address }}</div>
            @endif
        </div>
        <div class="text-right">
            <div class="text-gray-500 dark:text-gray-400 font-medium">Service & Seating</div>
            <div class="mt-1 flex items-center justify-end gap-2">
                @if($order->type === 'dine_in')
                    <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300 font-bold">🍽️ Dine-In</span>
                    <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-300 font-bold">🪑 Table {{ $order->table_number ?: 'N/A' }}</span>
                @elseif($order->type === 'takeaway')
                    <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-300 font-bold">🛍️ Takeaway</span>
                @else
                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300 font-bold">🛵 Delivery</span>
                @endif
            </div>
            <div class="mt-2">
                <span class="text-gray-500 dark:text-gray-400">Status:</span>
                <span class="font-black capitalize {{ $order->status === 'completed' ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' }}">
                    {{ $order->status }}
                </span>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <div>
        <div class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5">Ordered Dishes</div>
        <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
            <table class="w-full text-left text-xs">
                <thead class="nfc-modal-table-th font-bold">
                    <tr>
                        <th class="p-2.5">Dish</th>
                        <th class="p-2.5 text-center">Qty</th>
                        <th class="p-2.5 text-right">Price</th>
                        <th class="p-2.5 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($order->items as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <td class="p-2.5 font-bold text-gray-900 dark:text-gray-100">
                                {{ $item->menuItem?->name ?? 'Special Feast Dish' }}
                            </td>
                            <td class="p-2.5 text-center font-bold text-gray-700 dark:text-gray-300">
                                ×{{ $item->quantity }}
                            </td>
                            <td class="p-2.5 text-right text-gray-600 dark:text-gray-400 font-mono">
                                Rs. {{ number_format($item->unit_price, 0) }}
                            </td>
                            <td class="p-2.5 text-right font-black text-gray-900 dark:text-gray-100 font-mono">
                                Rs. {{ number_format($item->total_price, 0) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500 dark:text-gray-400">
                                No dish items attached to this order.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Calculations & Billing Details -->
    <div class="p-3 nfc-modal-box-inner rounded-xl space-y-1.5 text-xs">
        <div class="flex justify-between text-gray-600 dark:text-gray-400">
            <span>Dishes Subtotal:</span>
            <span class="font-mono font-bold text-gray-800 dark:text-gray-200">Rs. {{ number_format($order->subtotal, 0) }}</span>
        </div>
        @if((float)$order->tax > 0)
            <div class="flex justify-between text-gray-600 dark:text-gray-400">
                <span>GST / Service Tax:</span>
                <span class="font-mono font-bold text-gray-800 dark:text-gray-200">+ Rs. {{ number_format($order->tax, 0) }}</span>
            </div>
        @endif
        @if((float)$order->discount > 0)
            <div class="flex justify-between text-emerald-600 dark:text-emerald-400 font-medium">
                <span>Privilege Discount:</span>
                <span class="font-mono font-bold">- Rs. {{ number_format($order->discount, 0) }}</span>
            </div>
        @endif
        <div class="pt-2 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center text-sm font-black">
            <span class="text-gray-900 dark:text-gray-100">Grand Total:</span>
            <span class="text-emerald-600 dark:text-emerald-400 font-mono text-base">Rs. {{ number_format($order->total, 0) }}</span>
        </div>
        <div class="pt-1 flex justify-between items-center text-xs">
            <span class="text-gray-500 dark:text-gray-400">Payment Status:</span>
            <div class="flex items-center gap-2">
                <span class="font-bold {{ $order->payment_status === 'paid' ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' }}">
                    {{ $order->payment_status === 'paid' ? '💳 Paid' : '⏳ Pending Payment' }}
                </span>
                @if($order->payment_method)
                    <span class="px-2 py-0.5 rounded bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-mono text-[10px] uppercase">
                        {{ $order->payment_method }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    @if($order->special_notes)
        <div class="p-2.5 bg-amber-50/50 dark:bg-amber-950/20 rounded-lg border border-amber-200 dark:border-amber-900/40 text-xs">
            <div class="font-bold text-amber-800 dark:text-amber-300">👨‍🍳 Kitchen Notes:</div>
            <div class="text-gray-700 dark:text-gray-300 italic mt-0.5">{{ $order->special_notes }}</div>
        </div>
    @endif
</div>
