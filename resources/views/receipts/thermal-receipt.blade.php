@php
    $order = $order ?? null;
    $cashierName = $cashierName ?? auth()->user()?->name ?? 'admin';
    $isKot = ($type ?? 'bill') === 'kot';

    // Determine Server Name & Role (Waiter vs Cashier)
    $serverRole = 'Cashier';
    $serverName = $cashierName;
    if ($order) {
        if ($order->waiter) {
            $serverRole = 'Waiter';
            $serverName = $order->waiter->name;
        } elseif ($order->waiter_id && ($wUser = \App\Models\User::find($order->waiter_id))) {
            $serverRole = 'Waiter';
            $serverName = $wUser->name;
        } elseif ($order->user && $order->user->role === 'waiter') {
            $serverRole = 'Waiter';
            $serverName = $order->user->name;
        } elseif ($order->user) {
            $serverRole = 'Cashier';
            $serverName = $order->user->name;
        }
    }

    $riderName = $order?->rider_name ?? ($order?->special_notes && str_contains($order->special_notes, 'Rider:') ? trim(explode('Rider:', $order->special_notes)[1] ?? '') : null);
@endphp

<div id="thermal-receipt-container" class="pos-receipt-ticket" style="width: 280px; max-width: 100%; margin: 0 auto; background: #ffffff; color: #000000; font-family: 'Courier New', Courier, monospace; font-size: 11px; line-height: 1.25; padding: 12px 8px; box-sizing: border-box; text-align: left;">

    <!-- TOP HEADER / ROUND CIRCLE LOGO -->
    <div style="text-align: center; margin-bottom: 8px;">
        <div style="width: 68px; height: 68px; margin: 0 auto 6px; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #ffffff;">
            <img src="{{ asset('images/logo_circular.png') }}" 
                 alt="Nawabi Food Corner" 
                 style="width: 100%; height: 100%; object-fit: cover; display: block; filter: grayscale(100%) contrast(140%);">
        </div>
        
        <div style="font-size: 13px; font-weight: 900; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 3px;">
            NAWABI FOOD CORNER
        </div>
        
        <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; line-height: 1.25; margin-bottom: 3px;">
            NEAR AL-REHMAN GARDEN AKBAR<br>ROAD OKARA
        </div>
        
        <div style="font-size: 11px; font-weight: 800;">
            0311-8484987 : 0339-8484987
        </div>
        
        <!-- SERVICE TOKEN / TABLE IDENTIFIER -->
        <div style="font-size: 13px; font-weight: 900; margin-top: 6px; padding: 2px 0;">
            @if($isKot)
                <span style="background: #000000; color: #ffffff; padding: 2px 8px; border-radius: 2px;">*** KITCHEN KOT TICKET ***</span>
                <div style="margin-top: 4px; font-size: 12px;">
                    @if($order && $order->type === 'dine_in')
                        Dine In Table:- {{ $order->table_number ?? '1' }}
                    @elseif($order && $order->type === 'delivery')
                        Delivery Token:- {{ $order->token_number ?? substr($order->order_number, -4) ?? '1' }}
                    @else
                        Take Away Token:- {{ $order ? ($order->token_number ?? substr($order->order_number, -4)) : '1' }}
                    @endif
                </div>
            @else
                @if($order && $order->type === 'dine_in')
                    Dine In Table:- {{ $order->table_number ?? '1' }}
                @elseif($order && $order->type === 'delivery')
                    Delivery Token:- {{ $order->token_number ?? substr($order->order_number, -4) ?? '1' }}
                @else
                    Take Away Token:- {{ $order ? ($order->token_number ?? substr($order->order_number, -4)) : '1' }}
                @endif
            @endif
        </div>
    </div>

    <!-- CASHIER / WAITER & BILL METADATA -->
    <div style="font-size: 10px; font-weight: 700; margin-bottom: 4px;">
        <div style="display: flex; justify-content: space-between;">
            <span>/ A / {{ $serverRole }}: {{ $serverName }}</span>
            <span style="text-transform: uppercase;">{{ $order ? strtoupper($order->type) : 'DINE_IN' }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; margin-top: 2px;">
            <span>BILL# {{ $order ? $order->order_number : '29021' }}</span>
            <span>{{ $order && $order->created_at ? $order->created_at->format('d-m-Y  h:i A') : date('d-m-Y  h:i A') }}</span>
        </div>
        @if($order && $order->type === 'delivery' && !empty($riderName))
            <div style="display: flex; justify-content: space-between; margin-top: 2px; font-weight: 800;">
                <span>Rider: {{ $riderName }}</span>
                <span style="text-transform: uppercase; font-size: 9px; background: #000; color: #fff; padding: 0 4px; border-radius: 2px;">DELIVERY</span>
            </div>
        @endif
    </div>

    <!-- GUEST & DELIVERY DETAILS -->
    @if($order && ($order->customer_name || $order->customer_phone || ($order->type === 'delivery' && $order->customer_address) || ($order->type === 'delivery' && !empty($riderName))))
        <div style="font-size: 9.5px; font-weight: 700; margin-bottom: 4px; border: 1px dotted #000000; padding: 3px 5px;">
            @if($order->customer_name) <div>Guest: {{ $order->customer_name }}</div> @endif
            @if($order->customer_phone) <div>Phone: {{ $order->customer_phone }}</div> @endif
            @if($order->type === 'delivery' && $order->customer_address) <div>Address: {{ $order->customer_address }}</div> @endif
            @if($order->type === 'delivery' && !empty($riderName)) <div>Rider: {{ $riderName }}</div> @endif
        </div>
    @endif

    <!-- DASHED DIVIDER -->
    <div style="border-top: 1px dashed #000000; margin: 4px 0;"></div>

    <!-- ITEMS TABLE -->
    <table style="width: 100%; border-collapse: collapse; font-size: 10.5px; font-family: inherit;">
        <thead>
            <tr style="border-bottom: 1px dashed #000000;">
                <th style="text-align: left; padding: 3px 0; font-weight: 800; width: 48%;">Name</th>
                <th style="text-align: center; padding: 3px 0; font-weight: 800; width: 18%;">Rate</th>
                <th style="text-align: center; padding: 3px 0; font-weight: 800; width: 14%;">Qty</th>
                <th style="text-align: right; padding: 3px 0; font-weight: 800; width: 20%;">Amt</th>
            </tr>
        </thead>
        <tbody>
            @if($order && $order->items && count($order->items) > 0)
                @foreach($order->items as $idx => $item)
                    @php
                        $dishName = $item->menuItem?->name ?? 'Dish';
                        if (!empty($item->portion_size)) {
                            $dishName .= ' ' . strtoupper($item->portion_size);
                        }
                        $rate = (float) ($item->unit_price ?? 0);
                        $qty = (int) ($item->quantity ?? 1);
                        $amt = (float) ($item->total_price ?? ($rate * $qty));
                    @endphp
                    <tr>
                        <td style="padding: 2.5px 0; text-align: left; vertical-align: top; word-break: break-word; line-height: 1.2;">
                            {{ $idx + 1 }}.{{ $dishName }}
                        </td>
                        <td style="padding: 2.5px 0; text-align: center; vertical-align: top;">
                            {{ number_format($rate, 0) }}
                        </td>
                        <td style="padding: 2.5px 0; text-align: center; vertical-align: top; font-weight: 700;">
                            {{ $qty }}
                        </td>
                        <td style="padding: 2.5px 0; text-align: right; vertical-align: top;">
                            {{ number_format($amt, 0) }}
                        </td>
                    </tr>
                @endforeach
            @else
                <!-- Sample items if order has no items -->
                <tr>
                    <td style="padding: 2.5px 0; text-align: left;">1.Chicken Fajita Pizza L</td>
                    <td style="padding: 2.5px 0; text-align: center;">1350</td>
                    <td style="padding: 2.5px 0; text-align: center;">1</td>
                    <td style="padding: 2.5px 0; text-align: right;">1350</td>
                </tr>
                <tr>
                    <td style="padding: 2.5px 0; text-align: left;">2.Hot Wings</td>
                    <td style="padding: 2.5px 0; text-align: center;">600</td>
                    <td style="padding: 2.5px 0; text-align: center;">1</td>
                    <td style="padding: 2.5px 0; text-align: right;">600</td>
                </tr>
                <tr>
                    <td style="padding: 2.5px 0; text-align: left;">3.Zinger Burger</td>
                    <td style="padding: 2.5px 0; text-align: center;">350</td>
                    <td style="padding: 2.5px 0; text-align: center;">1</td>
                    <td style="padding: 2.5px 0; text-align: right;">350</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- DOTTED DIVIDER -->
    <div style="border-top: 1px dotted #000000; margin: 6px 0;"></div>

    @if(!$isKot)
        <!-- FINANCIAL TOTALS -->
        @php
            $subtotal = $order ? ($order->subtotal ?? $order->total) : 4220;
            $tax = $order ? (float)($order->tax ?? 0) : 0;
            $discount = $order ? (float)($order->discount ?? 0) : 0;
            $grandTotal = $order ? (float)($order->total ?? $subtotal) : 4220;
        @endphp

        <div style="font-size: 11px; line-height: 1.35;">
            <div style="display: flex; justify-content: space-between; font-weight: 700;">
                <span style="letter-spacing: 0.5px;">SUB TOTAL</span>
                <span style="font-weight: 800;">{{ number_format($subtotal, 0) }}</span>
            </div>

            @if($tax > 0)
                <div style="display: flex; justify-content: space-between; font-size: 10px; margin-top: 2px;">
                    <span>GST TAX</span>
                    <span>{{ number_format($tax, 0) }}</span>
                </div>
            @endif

            @if($discount > 0)
                <div style="display: flex; justify-content: space-between; font-size: 10px; margin-top: 2px;">
                    <span>DISCOUNT</span>
                    <span>-{{ number_format($discount, 0) }}</span>
                </div>
            @endif

            <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 900; margin-top: 5px; padding-top: 4px; border-top: 1px dashed #000000;">
                <span style="letter-spacing: 0.5px;">TOTAL CHARGE</span>
                <span style="font-size: 14px;">{{ number_format($grandTotal, 0) }}</span>
            </div>
        </div>

        <!-- BARCODE SECTION -->
        <div style="text-align: center; margin: 12px 0 6px;">
            <div style="display: inline-flex; justify-content: center; align-items: flex-end; height: 36px; gap: 2px; padding: 0 4px;">
                @foreach([2,1,3,1,2,3,1,2,1,3,2,1,1,3,2,1,2,3,1,2,3,1,2,1,3,2,1,2,3,1,2,1,3,1] as $bar)
                    <span style="display: inline-block; width: {{ $bar }}px; height: {{ 26 + ($loop->index % 4) * 2 }}px; background-color: #000000;"></span>
                @endforeach
            </div>
            <div style="font-size: 8.5px; letter-spacing: 1px; margin-top: 2px;">
                *{{ $order ? $order->order_number : '29021' }}*
            </div>
        </div>

        <!-- GREETING -->
        <div style="text-align: center; font-size: 9.5px; font-weight: 800; text-transform: uppercase; margin: 6px 0 2px;">
            THANKS FOR COMMING NAWABI FOOD CORNER
        </div>
        <div style="text-align: center; font-size: 9px; font-style: italic; margin-bottom: 8px;">
            Have a nice day!
        </div>
    @else
        <!-- KOT NOTES -->
        @if($order && $order->special_notes)
            <div style="margin-top: 6px; padding: 4px; border: 1px solid #000000; font-size: 10px; font-weight: bold;">
                NOTE: {{ $order->special_notes }}
            </div>
        @endif
        <div style="text-align: center; font-size: 9px; font-weight: bold; margin-top: 8px; text-transform: uppercase;">
            *** DISPATCH TO KITCHEN CHEF ***
        </div>
    @endif

    <!-- SOLID DIVIDER -->
    <div style="border-top: 1px solid #000000; margin: 6px 0;"></div>

    <!-- PERMANENT DEVELOPER COPYRIGHT (NON-EDITABLE BY ANY ROLE) -->
    <div style="text-align: center; font-size: 8.5px; font-family: monospace; font-weight: bold; line-height: 1.35; color: #000000;">
        Software designed and developed by: MNS Technologies and consultant<br>
        0347-6824180
    </div>

</div>
