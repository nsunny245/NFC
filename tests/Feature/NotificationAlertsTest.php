<?php

namespace Tests\Feature;

use App\Mail\ReservationBookingMail;
use App\Mail\OrderReceiptMail;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Reservation;
use App\Models\User;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class NotificationAlertsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_dispatches_notifications_on_reservation_creation_and_status_changes()
    {
        Mail::fake();

        // 1. Create a reservation (defaults to pending)
        $reservation = Reservation::create([
            'guest_name' => 'Mian Muhammad',
            'guest_phone' => '03118484987',
            'guest_email' => 'mian@example.com',
            'guest_count' => 4,
            'reservation_time' => Carbon::tomorrow()->setTime(19, 30),
            'special_requests' => 'Mild spices, outdoor seating.',
            'status' => 'pending',
        ]);

        // Assert pending email was sent
        Mail::assertSent(ReservationBookingMail::class, function ($mail) use ($reservation) {
            return $mail->hasTo('mian@example.com') &&
                   $mail->reservation->id === $reservation->id &&
                   $mail->statusLabel === 'Pending';
        });

        // 2. Update status to confirmed
        $reservation->update([
            'status' => 'confirmed',
            'table_number' => 'Dera-12',
        ]);

        // Assert confirmed email was sent
        Mail::assertSent(ReservationBookingMail::class, function ($mail) use ($reservation) {
            return $mail->hasTo('mian@example.com') &&
                   $mail->reservation->status === 'confirmed' &&
                   $mail->reservation->table_number === 'Dera-12';
        });

        // 3. Update status to seated
        $reservation->update(['status' => 'seated']);

        // Assert seated email was sent
        Mail::assertSent(ReservationBookingMail::class, function ($mail) use ($reservation) {
            return $mail->hasTo('mian@example.com') &&
                   $mail->reservation->status === 'seated';
        });
    }

    /** @test */
    public function it_dispatches_notifications_on_order_creation_and_status_changes()
    {
        Mail::fake();

        // Setup user, category, and items
        $user = User::factory()->create([
            'name' => 'Prince Ali',
            'email' => 'prince.ali@nawabidera.com',
        ]);

        $category = MenuCategory::create([
            'name' => 'Nawabi Karahi',
            'slug' => 'nawabi-karahi',
        ]);

        $menuItem = MenuItem::create([
            'category_id' => $category->id,
            'name' => 'Royal Mutton Karahi',
            'price' => 2500,
            'is_available' => true,
        ]);

        // 1. Create order
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ND-2026-9999',
            'subtotal' => 2500,
            'tax' => 250,
            'discount' => 0,
            'total' => 2750,
            'status' => 'pending',
            'type' => 'dine_in',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'menu_item_id' => $menuItem->id,
            'quantity' => 1,
            'unit_price' => 2500,
            'total_price' => 2500,
        ]);

        // Assert pending order receipt email was sent
        Mail::assertSent(OrderReceiptMail::class, function ($mail) use ($order) {
            return $mail->hasTo('prince.ali@nawabidera.com') &&
                   $mail->order->id === $order->id &&
                   $mail->order->order_number === 'ND-2026-9999';
        });

        // 2. Update status to preparing
        $order->update(['status' => 'preparing']);

        // Assert preparing status email was sent
        Mail::assertSent(OrderReceiptMail::class, function ($mail) use ($order) {
            return $mail->hasTo('prince.ali@nawabidera.com') &&
                   $mail->order->status === 'preparing';
        });

        // 3. Update status to ready
        $order->update(['status' => 'ready']);

        // Assert ready status email was sent
        Mail::assertSent(OrderReceiptMail::class, function ($mail) use ($order) {
            return $mail->hasTo('prince.ali@nawabidera.com') &&
                   $mail->order->status === 'ready';
        });
    }

    /** @test */
    public function it_successfully_uses_mock_logger_when_twilio_credentials_are_absent()
    {
        // Force config keys to be empty/null
        config([
            'services.twilio.sid' => null,
            'services.twilio.auth_token' => null,
            'services.twilio.number' => null,
        ]);

        // Spy on Log facade
        Log::shouldReceive('info')
            ->once()
            ->withArgs(function ($message) {
                return str_contains($message, 'SMS Mock Logger') &&
                       str_contains($message, '03118484987') &&
                       str_contains($message, 'Hello Nawabi guest');
            });

        $smsService = new SmsService();
        $result = $smsService->send('03118484987', 'Hello Nawabi guest');

        $this->assertTrue($result);
    }

    /** @test */
    public function it_uses_twilio_http_api_when_credentials_are_fully_configured()
    {
        // Mock config keys
        config([
            'services.twilio.sid' => 'AC_TEST_SID',
            'services.twilio.auth_token' => 'TEST_TOKEN',
            'services.twilio.number' => '+15005550006',
        ]);

        // Fake outgoing Http requests to Twilio
        Http::fake([
            'https://api.twilio.com/*' => Http::response([
                'sid' => 'SM_TEST_MESSAGE_SID',
                'status' => 'queued'
            ], 201)
        ]);

        $smsService = new SmsService();
        $result = $smsService->send('03118484987', 'Your feast awaits you!');

        $this->assertTrue($result);

        // Assert that the proper Twilio endpoint was hit with credentials and post body
        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.twilio.com/2010-04-01/Accounts/AC_TEST_SID/Messages.json' &&
                   $request->method() === 'POST' &&
                   $request['To'] === '03118484987' &&
                   $request['From'] === '+15005550006' &&
                   $request['Body'] === 'Your feast awaits you!';
        });
    }
}
