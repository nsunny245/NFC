<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class PosReceiptSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-printer';

    protected static string $view = 'filament.pages.pos-receipt-settings';

    protected static ?string $navigationGroup = 'Royal Back-Office RRP';

    protected static ?string $navigationLabel = 'POS Receipt & Branding Specs';

    protected static ?string $title = 'POS Thermal Receipt & Branding Center';

    protected static ?int $navigationSort = 6;
}
