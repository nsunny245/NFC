<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NFC - Nawabi Food Corner Reservation</title>
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
                                Reservation Status Update
                            </h2>
                            <p style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.6; color: #e0e0e0; text-align: center;">
                                Greetings, <strong>{{ $reservation->guest_name }}</strong>. We are pleased to provide an update regarding your table reservation request.
                            </p>
                        </td>
                    </tr>

                    <!-- Reservation Status Badge -->
                    <tr>
                        <td align="center" style="padding: 0 40px 30px 40px;">
                            <span style="display: inline-block; padding: 8px 24px; border-radius: 50px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;
                                @if($reservation->status === 'confirmed')
                                    background-color: #2e7d32; color: #ffffff; border: 1px solid #d4af37;
                                @elseif($reservation->status === 'seated')
                                    background-color: #1565c0; color: #ffffff; border: 1px solid #d4af37;
                                @elseif($reservation->status === 'cancelled')
                                    background-color: #c62828; color: #ffffff;
                                @else
                                    background-color: #f57f17; color: #ffffff; border: 1px solid #d4af37;
                                @endif
                            ">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </td>
                    </tr>

                    <!-- Details Box -->
                    <tr>
                        <td style="padding: 0 40px 30px 40px;">
                            <table border="0" cellpadding="12" cellspacing="0" width="100%" style="background-color: #120e0c; border: 1px solid rgba(212, 175, 55, 0.2); border-radius: 6px;">
                                <tr>
                                    <td width="40%" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; color: #c5a059; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; border-bottom: 1px solid rgba(212,175,55,0.1);">
                                        Guest Count:
                                    </td>
                                    <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 15px; color: #ffffff; border-bottom: 1px solid rgba(212,175,55,0.1);">
                                        {{ $reservation->guest_count }} Noble Guests
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; color: #c5a059; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; border-bottom: 1px solid rgba(212,175,55,0.1);">
                                        Date & Time:
                                    </td>
                                    <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 15px; color: #ffffff; border-bottom: 1px solid rgba(212,175,55,0.1);">
                                        {{ $reservation->reservation_time->format('M d, Y \a\t h:i A') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; color: #c5a059; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; border-bottom: 1px solid rgba(212,175,55,0.1);">
                                        Table Number:
                                    </td>
                                    <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 15px; color: #ffffff; border-bottom: 1px solid rgba(212,175,55,0.1);">
                                        {{ $reservation->table_number ?: 'To be assigned upon arrival' }}
                                    </td>
                                </tr>
                                @if($reservation->special_requests)
                                <tr>
                                    <td valign="top" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; color: #c5a059; text-transform: uppercase; letter-spacing: 1px; font-weight: bold;">
                                        Special Requests:
                                    </td>
                                    <td style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; color: #e0e0e0; line-height: 1.4; font-style: italic;">
                                        "{{ $reservation->special_requests }}"
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </td>
                    </tr>

                    <!-- Instructions / Actions -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px; text-align: center; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.5; color: #b3b3b3;">
                            @if($reservation->status === 'confirmed')
                                <p style="color: #e5c158; font-weight: bold; font-family: 'Georgia', serif;">We have secured our finest seating arrangement for you.</p>
                                <p>If you wish to make changes or have further requests, please do not hesitate to contact our royal hosts.</p>
                            @elseif($reservation->status === 'pending')
                                <p>Our royal hosts are currently checking table availability for your selected timing. We will update you with confirmation shortly.</p>
                            @elseif($reservation->status === 'seated')
                                <p>Welcome to NFC - Nawabi Food Corner! We trust you are enjoying your royal feast.</p>
                            @elseif($reservation->status === 'cancelled')
                                <p>We regret that your reservation has been cancelled. We look forward to the opportunity of hosting you on another occasion.</p>
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
