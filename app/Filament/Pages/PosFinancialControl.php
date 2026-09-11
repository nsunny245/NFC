<?php

namespace App\Filament\Pages;

use App\Models\PosSetting;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class PosFinancialControl extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static string $view = 'filament.pages.pos-financial-control';

    protected static ?string $navigationGroup = 'Royal Back-Office RRP';

    protected static ?string $navigationLabel = 'POS Financial Terminal Control';

    protected static ?string $title = 'POS Financial & Terminal Controls';

    protected static ?int $navigationSort = 5;

    public bool $vatEnabled = true;
    public float $vatPercentage = 16.00;
    public string $vatLabel = 'GST Tax (16%)';

    public bool $serviceFeeEnabled = false;
    public float $serviceFeePercentage = 5.00;

    public bool $cardPaymentEnabled = true;
    public float $cardFeePercentage = 0.00;
    public string $cardTerminalName = 'Bank POS / Cards';

    public function mount(): void
    {
        $this->loadSettings();
    }

    public function loadSettings(): void
    {
        $this->vatEnabled = PosSetting::isVatEnabled();
        $this->vatPercentage = PosSetting::getVatPercentage();
        $this->vatLabel = (string)PosSetting::get('vat_label', 'GST Tax (16%)');

        $this->serviceFeeEnabled = PosSetting::isServiceFeeEnabled();
        $this->serviceFeePercentage = PosSetting::getServiceFeePercentage();

        $this->cardPaymentEnabled = PosSetting::isCardPaymentEnabled();
        $this->cardFeePercentage = PosSetting::getCardFeePercentage();
        $this->cardTerminalName = (string)PosSetting::get('card_terminal_name', 'Bank POS / Cards');
    }

    public function toggleVat(): void
    {
        $this->vatEnabled = !$this->vatEnabled;
        $this->saveSettings();
    }

    public function toggleServiceFee(): void
    {
        $this->serviceFeeEnabled = !$this->serviceFeeEnabled;
        $this->saveSettings();
    }

    public function toggleCardPayment(): void
    {
        $this->cardPaymentEnabled = !$this->cardPaymentEnabled;
        $this->saveSettings();
    }

    public function saveSettings(): void
    {
        $this->validate([
            'vatPercentage' => 'required|numeric|min:0|max:100',
            'serviceFeePercentage' => 'required|numeric|min:0|max:100',
            'cardFeePercentage' => 'required|numeric|min:0|max:100',
            'vatLabel' => 'required|string|max:50',
            'cardTerminalName' => 'required|string|max:50',
        ]);

        PosSetting::set('vat_enabled', $this->vatEnabled);
        PosSetting::set('vat_percentage', $this->vatPercentage);
        PosSetting::set('vat_label', $this->vatLabel);

        PosSetting::set('service_fee_enabled', $this->serviceFeeEnabled);
        PosSetting::set('service_fee_percentage', $this->serviceFeePercentage);

        PosSetting::set('card_payment_enabled', $this->cardPaymentEnabled);
        PosSetting::set('card_fee_percentage', $this->cardFeePercentage);
        PosSetting::set('card_terminal_name', $this->cardTerminalName);

        Notification::make()
            ->title('POS Financial Controls Saved Successfully! 💳')
            ->body("VAT is " . ($this->vatEnabled ? "ENABLED ({$this->vatPercentage}%)" : "DISABLED") . 
                  " | Service Fee is " . ($this->serviceFeeEnabled ? "ENABLED ({$this->serviceFeePercentage}%)" : "DISABLED") . 
                  " | Card Section: " . ($this->cardPaymentEnabled ? "ACTIVE" : "DISABLED"))
            ->success()
            ->send();
    }

    public function setVatPreset(float $rate, string $label): void
    {
        $this->vatPercentage = $rate;
        $this->vatLabel = $label;
        $this->vatEnabled = ($rate > 0);
        $this->saveSettings();
    }

    public function setServiceFeePreset(float $rate): void
    {
        $this->serviceFeePercentage = $rate;
        $this->serviceFeeEnabled = ($rate > 0);
        $this->saveSettings();
    }

    public function setCardFeePreset(float $rate): void
    {
        $this->cardFeePercentage = $rate;
        $this->saveSettings();
    }

    public function resetToDefaults(): void
    {
        $this->vatEnabled = true;
        $this->vatPercentage = 16.00;
        $this->vatLabel = 'GST Tax (16%)';

        $this->serviceFeeEnabled = false;
        $this->serviceFeePercentage = 5.00;

        $this->cardPaymentEnabled = true;
        $this->cardFeePercentage = 0.00;
        $this->cardTerminalName = 'Bank POS / Cards';

        $this->saveSettings();
    }
}
