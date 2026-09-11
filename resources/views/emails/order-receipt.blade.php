<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NFC - Nawabi Food Corner Order Receipt</title>
</head>
<body style="margin: 0; padding: 0; background-color: #111111; font-family: 'Georgia', 'Playfair Display', serif; color: #ffffff; -webkit-font-smoothing: antialiased;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #111111; padding: 40px 10px;">
        <tr>
            <td align="center">
                <!-- Outer Card -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #1a1613; border: 2px solid #d4af37; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.5);">
                    <!-- Royal Header -->
                    <tr>
                        <td align="center" style="padding: 40px 20px 20px 20px; border-bottom: 1px solid rgba(212, 175, 55, 0.2);">
                            <div style="font-size: 28px; color: #d4af37; font-weight: bold; letter-spacing: 3px; text-transform: uppercase;">
                                👑 NFC - NAWABI FOOD CORNER
                            </div>
                            <div style="font-size: 12px; color: #c5a059; letter-spacing: 2px; text-transform: uppercase; margin-top: 5px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                                Royal Taste, Every Bite
                            </div>
                        </td>
                    </tr>

                    <!-- Greeting & Main Message -->
                    <tr>
                        <td style="padding: 40px 40px 20px 40px;">
                            <h2 style="color: #e5c158; margin-top: 0; font-weight: normal; font-size: 22px; text-align: center; border-bottom: 1px solid rgba(212,175,55,0.1); padding-bottom: 15px;">
                                Order Status Update
                            </h2>
                            <p style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.6; color: #e0e0e0; text-align: center;">
                                Greetings, <strong>{{ $order->user ? $order->user->name : 'Valued Guest' }}</strong>. Thank you for ordering from NFC - Nawabi Food Corner.
                            </p>
                        </td>
                    </tr>

                    <!-- Order Metadata Box -->
                    <tr>
                        <td style="padding: 0 40px 20px 40px;">
                            <table border="0" cellpadding="10" cellspacing="0" width="100%" style="background-color: #120e0c; border: 1px solid rgba(212, 175, 55, 0.2); border-radius: 6px; text-align: left; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px;">
                                <tr>
                                    <td style="color: #c5a059; font-weight: bold; width: 35%;">Order Number:</td>
                                    <td style="color: #ffffff;">#{{ $order->order_number }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #c5a059; font-weight: bold;">Order Type:</td>
                                    <td style="color: #ffffff;">{{ ucfirst(str_replace('_', ' ', $order->type)) }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #c5a059; font-weight: bold;">Order Status:</td>
                                    <td>
                                        <span style="display: inline-block; padding: 3px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; text-transform: uppercase;
                                            @if($order->status === 'completed')
                                                background-color: #2e7d32; color: #ffffff;
                                            @elseif($order->status === 'preparing')
                                                background-color: #f57f17; color: #ffffff;
                                            @elseif($order->status === 'ready')
                                                background-color: #1565c0; color: #ffffff;
                                            @elseif($order->status === 'cancelled')
                                                background-color: #c62828; color: #ffffff;
                                            @else
                                                background-color: #616161; color: #ffffff;
                                            @endif
                                        ">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @if($order->special_notes)
                                <tr>
                                    <td style="color: #c5a059; font-weight: bold;" valign="top">Special Notes:</td>
                                    <td style="color: #e0e0e0; font-style: italic;">"{{ $order->special_notes }}"</td>
                                </tr>
                                @endif
                            </table>
                        </td>
                    </tr>

                    <!-- Invoice Items Table -->
                    <tr>
                        <td style="padding: 10px 40px 20px 40px;">
                            <h3 style="color: #e5c158; font-size: 16px; margin: 0 0 10px 0; text-align: left; text-transform: uppercase; letter-spacing: 1px;">
                                Invoice Items
                            </h3>
                            <table border="0" cellpadding="10" cellspacing="0" width="100%" style="border-collapse: collapse; text-align: left; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #d4af37; background-color: #120e0c;">
                                        <th style="color: #c5a059; font-weight: bold; padding: 8px;">Item</th>
                                        <th style="color: #c5a059; font-weight: bold; text-align: center; padding: 8px; width: 10%;">Qty</th>
                                        <th style="color: #c5a059; font-weight: bold; text-align: right; padding: 8px; width: 25%;">Unit Price</th>
                                        <th style="color: #c5a059; font-weight: bold; text-align: right; padding: 8px; width: 25%;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr style="border-bottom: 1px solid rgba(212, 175, 55, 0.1);">
                                            <td style="color: #ffffff; padding: 10px 8px;">
                                                <strong>{{ $item->menuItem ? $item->menuItem->name : 'Menu Item' }}</strong>
                                            </td>
                                            <td style="color: #ffffff; text-align: center; padding: 10px 8px;">
                                                {{ $item->quantity }}
                                            </td>
                                            <td style="color: #ffffff; text-align: right; padding: 10px 8px;">
                                                Rs. {{ number_format($item->unit_price, 0) }}
                                            </td>
                                            <td style="color: #e5c158; text-align: right; padding: 10px 8px; font-weight: bold;">
                                                Rs. {{ number_format($item->total_price, 0) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <!-- Invoice Summary -->
                    <tr>
                        <td style="padding: 0 40px 30px 40px;">
                            <table border="0" cellpadding="8" cellspacing="0" width="50%" align="right" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; text-align: right;">
                                <tr>
                                    <td style="color: #c5a059; padding: 5px 0;">Subtotal:</td>
                                    <td style="color: #ffffff; font-weight: bold; padding: 5px 0;">Rs. {{ number_format($order->subtotal, 0) }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #c5a059; padding: 5px 0;">Tax:</td>
                                    <td style="color: #ffffff; padding: 5px 0;">Rs. {{ number_format($order->tax, 0) }}</td>
                                </tr>
                                @if($order->discount > 0)
                                <tr>
                                    <td style="color: #2e7d32; padding: 5px 0;">Discount:</td>
                                    <td style="color: #2e7d32; font-weight: bold; padding: 5px 0;">- Rs. {{ number_format($order->discount, 0) }}</td>
                                </tr>
                                @endif
                                <tr style="border-top: 1px solid #d4af37;">
                                    <td style="color: #e5c158; font-size: 16px; font-weight: bold; padding: 10px 0;">Grand Total:</td>
                                    <td style="color: #e5c158; font-size: 18px; font-weight: bold; padding: 10px 0;">Rs. {{ number_format($order->total, 0) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Message text depending on status -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px; text-align: center; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.5; color: #b3b3b3;">
                            @if($order->status === 'pending')
                                <p>We have received your royal order! Our expert chefs will begin preparing it as soon as the booking is accepted.</p>
                            @elseif($order->status === 'preparing')
                                <p>Your imperial feast is currently being prepared with the freshest ingredients by our Nawabi culinary masters.</p>
                            @elseif($order->status === 'ready')
                                <p style="color: #e5c158; font-weight: bold; font-family: 'Georgia', serif; font-size: 16px;">Your feast is prepared and ready!</p>
                                <p>
                                    @if($order->type === 'dine_in')
                                        Please join us at your table, and we will serve you immediately.
                                    @elseif($order->type === 'takeaway')
                                        It is packaged and waiting for your noble pickup.
                                    @elseif($order->type === 'delivery')
                                        Our delivery cavalry has loaded it up and is en route.
                                    @endif
                                </p>
                            @elseif($order->status === 'completed')
                                <p>We trust your dining experience was nothing short of regal. We look forward to serving you again soon.</p>
                            @elseif($order->status === 'cancelled')
                                <p>Your order has been cancelled. If this was done in error or you need assistance, please contact us immediately.</p>
                            @endif
                        </td>
                    </tr>

                    <!-- Royal Footer -->
                    <tr>
                        <td align="center" style="padding: 30px 20px; background-color: #120e0c; border-top: 1px solid rgba(212, 175, 55, 0.2);">
                            <p style="font-size: 14px; color: #d4af37; margin: 0; font-style: italic;">
                                "Royal Taste, Every Bite"
                            </p>
                            <p style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; color: #666666; margin: 10px 0 0 0; text-transform: uppercase; letter-spacing: 1px;">
                                NFC - Nawabi Food Corner, Akbar Road Near Rahman Garden, Okara (Tel: 0311-8484987)
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
