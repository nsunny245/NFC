<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PosSyncApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_and_order_sync_require_a_terminal_token(): void
    {
        $this->postJson('/api/pos/sync/pull')->assertUnauthorized();
        $this->postJson('/api/pos/sync/push', ['orders' => []])->assertUnauthorized();
    }

    public function test_authenticated_catalog_never_exposes_passwords_pins_or_tokens(): void
    {
        $terminal = User::factory()->create([
            'role' => 'cashier',
            'is_active' => true,
            'terminal_code' => 'POS-TEST',
            'api_token' => 'nfc_test_terminal_token',
            'pin' => '1234',
        ]);

        $response = $this->withHeader('X-Terminal-Token', $terminal->api_token)
            ->postJson('/api/pos/sync/pull');

        $response->assertOk()->assertJsonPath('status', 'success');
        $staff = $response->json('staff.0');
        $this->assertArrayNotHasKey('password', $staff);
        $this->assertArrayNotHasKey('pin', $staff);
        $this->assertArrayNotHasKey('api_token', $staff);
        $this->assertArrayNotHasKey('email', $staff);
    }

    public function test_sync_uses_the_authenticated_terminal_identity(): void
    {
        $terminal = User::factory()->create([
            'role' => 'cashier',
            'is_active' => true,
            'terminal_code' => 'POS-SECURE',
            'api_token' => 'nfc_secure_terminal_token',
        ]);

        $payload = [
            'terminal_code' => 'SPOOFED',
            'orders' => [[
                'uuid' => 'OFF-TEST-0001',
                'order_number' => 'POS-1001',
                'subtotal' => 500,
                'total' => 500,
                'items' => [],
            ]],
        ];

        $this->withHeader('X-Terminal-Token', $terminal->api_token)
            ->postJson('/api/pos/sync/push', $payload)
            ->assertOk()
            ->assertJsonPath('synced_count', 1);

        $this->assertDatabaseHas('orders', [
            'uuid' => 'OFF-TEST-0001',
            'terminal_code' => 'POS-SECURE',
            'user_id' => $terminal->id,
        ]);
    }
}
