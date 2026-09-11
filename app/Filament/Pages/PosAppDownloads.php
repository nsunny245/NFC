<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\File;

class PosAppDownloads extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';

    protected static string $view = 'filament.pages.pos-app-downloads';

    protected static ?string $navigationGroup = 'Royal Back-Office RRP';

    protected static ?string $navigationLabel = 'Standalone POS Apps';

    protected static ?string $title = 'Standalone POS Apps & Offline Terminals';

    protected static ?int $navigationSort = 2;

    public string $serverUrl = '';
    public string $apiSyncUrl = '';
    public array $terminals = [];
    public bool $windowsExeReady = false;
    public bool $macDmgReady = false;
    public bool $windowsZipReady = false;

    public function mount(): void
    {
        $this->serverUrl = url('/');
        $this->apiSyncUrl = url('/api/pos/sync');

        $this->terminals = User::where('is_active', true)
            ->where(function ($q) {
                $q->whereNotNull('terminal_code')
                  ->orWhere('role', 'cashier');
            })
            ->get(['id', 'name', 'email', 'role', 'pin', 'terminal_code', 'api_token'])
            ->makeVisible(['api_token'])
            ->toArray();

        $downloadsDir = public_path('downloads');
        $this->windowsExeReady = File::exists($downloadsDir . '/Nawabi-Food-Corner-POS-Setup.exe');
        $this->macDmgReady = File::exists($downloadsDir . '/Nawabi-Food-Corner-POS.dmg');
        $this->windowsZipReady = File::exists($downloadsDir . '/Nawabi-Food-Corner-POS-Windows.zip');
    }

    public function copyNotification(string $type): void
    {
        Notification::make()
            ->title('Copied to Clipboard')
            ->body("{$type} copied successfully. Paste into the terminal configuration.")
            ->success()
            ->send();
    }
}
