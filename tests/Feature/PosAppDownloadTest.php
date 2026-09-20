<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PosAppDownloadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test download endpoints for Windows EXE, macOS DMG, and ZIP.
     */
    public function test_pos_app_download_endpoints(): void
    {
        $responseExe = $this->get('/downloads/pos-app/exe');
        $responseExe->assertStatus(200);
        $responseExe->assertHeader('content-disposition');

        $responseDmg = $this->get('/downloads/pos-app/dmg');
        $responseDmg->assertStatus(200);
        $responseDmg->assertHeader('content-disposition');

        $responseZip = $this->get('/downloads/pos-app/portable');
        $responseZip->assertStatus(200);
        $responseZip->assertHeader('content-disposition');

        $this->get('/downloads/pos-app/windows-legacy')
            ->assertOk()
            ->assertHeader('content-type', 'application/vnd.microsoft.portable-executable');

        $this->get('/downloads/pos-app/mac-intel')
            ->assertOk()
            ->assertHeader('content-type', 'application/x-apple-diskimage');
    }

    /**
     * Test Admin Standalone Apps Page access.
     */
    public function test_admin_pos_downloads_page_accessible(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);
        $this->actingAs($admin);

        \Livewire\Livewire::test(\App\Filament\Pages\PosAppDownloads::class)
            ->assertSuccessful()
            ->assertSee('Standalone POS Apps & Offline Terminals')
            ->assertSee('Download Windows App (.exe)')
            ->assertSee('Download macOS App (.dmg)')
            ->assertSee('Waiter Pad Mobile App');
    }
}
