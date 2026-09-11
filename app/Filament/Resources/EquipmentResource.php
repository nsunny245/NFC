<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentResource\Pages;
use App\Models\Equipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'Equipment Registry';

    protected static ?string $modelLabel = 'Equipment Item';

    protected static ?string $pluralModelLabel = 'Equipment Registry';

    protected static ?string $navigationGroup = 'Royal Back-Office RRP';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Equipment Identity')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Royal Karahi Wok Stove Rig'),
                        Forms\Components\TextInput::make('quantity')
                            ->label('Quantity in Restaurant')
                            ->required()
                            ->numeric()
                            ->default(1),
                        Forms\Components\Select::make('category')
                            ->options([
                                'kitchen_appliances' => '🍳 Kitchen Appliances & Cookware',
                                'dining_furniture' => '🪑 Dining & Seating Furniture',
                                'cooling_heating' => '❄️ Cooling & Heating Systems',
                                'pos_it' => '🖥️ POS Terminals & IT Devices',
                                'lighting_electrical' => '⚡ Lighting & Electrical',
                                'other' => '📦 Other Equipment',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('serial_number')
                            ->label('Serial / Asset Number')
                            ->placeholder('e.g. STV-ND-992A')
                            ->maxLength(255)
                            ->default(null),
                    ])->columns(4),

                Forms\Components\Section::make('Financial & Vital Status')
                    ->schema([
                        Forms\Components\DatePicker::make('purchase_date')
                            ->label('Date of Purchase'),
                        Forms\Components\TextInput::make('purchase_cost')
                            ->label('Purchase Cost')
                            ->numeric()
                            ->prefix('Rs.')
                            ->default(0.00),
                        Forms\Components\Select::make('functional_status')
                            ->label('Functional Health Status')
                            ->options([
                                'operational' => 'Operational (Normal)',
                                'under_maintenance' => 'Under Maintenance',
                                'degraded' => 'Degraded (Needs Attention)',
                                'broken' => 'Broken / Out of Order',
                            ])
                            ->required()
                            ->default('operational'),
                    ])->columns(3),

                Forms\Components\Section::make('Maintenance Cycles')
                    ->schema([
                        Forms\Components\DatePicker::make('last_maintenance_date')
                            ->label('Last Maintenance Conducted'),
                        Forms\Components\DatePicker::make('next_maintenance_date')
                            ->label('Next Maintenance Scheduled'),
                        Forms\Components\Textarea::make('notes')
                            ->placeholder('Any operational instructions or mechanical details...')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Equipment / Asset')
                    ->searchable()
                    ->sortable()
                    ->weight('black')
                    ->icon('heroicon-m-wrench-screwdriver')
                    ->description(fn (Equipment $record): string => "Asset Code: " . ($record->serial_number ?: 'ND-EQ-' . str_pad($record->id, 3, '0', STR_PAD_LEFT))),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Count')
                    ->badge()
                    ->formatStateUsing(fn ($state) => "×{$state} Units")
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('category')
                    ->label('Category')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'kitchen_appliances' => '🍳 Kitchen & Cookware',
                        'dining_furniture' => '🪑 Dining & Furniture',
                        'cooling_heating' => '❄️ Cooling & HVAC',
                        'pos_it' => '🖥️ POS & Electronics',
                        'lighting_electrical' => '⚡ Solar & Power',
                        default => '📦 Utility & Assets',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'kitchen_appliances' => 'danger',
                        'dining_furniture' => 'warning',
                        'cooling_heating' => 'info',
                        'pos_it' => 'primary',
                        'lighting_electrical' => 'success',
                        default => 'gray',
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('functional_status')
                    ->label('Operational Health')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'operational' => '🟢 Operational (Good)',
                        'under_maintenance' => '🔧 Maintenance',
                        'degraded' => '⚠️ Degraded',
                        'broken' => '✕ Out of Order',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'operational' => 'success',
                        'under_maintenance' => 'warning',
                        'degraded' => 'warning',
                        'broken' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('purchase_cost')
                    ->label('Est. Value')
                    ->formatStateUsing(fn ($state) => 'Rs. ' . number_format($state, 0))
                    ->weight('bold')
                    ->sortable(),

                Tables\Columns\TextColumn::make('last_maintenance_date')
                    ->label('Last Serviced')
                    ->date('M d, Y')
                    ->sortable()
                    ->placeholder('Active in Service')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'kitchen_appliances' => '🍳 Kitchen Appliances & Cookware',
                        'dining_furniture' => '🪑 Dining & Furniture',
                        'cooling_heating' => '❄️ Cooling & HVAC',
                        'pos_it' => '🖥️ POS & Electronics',
                        'lighting_electrical' => '⚡ Solar & Power',
                        'other' => '📦 Utility & Assets',
                    ]),
                Tables\Filters\SelectFilter::make('functional_status')
                    ->label('Health Status')
                    ->options([
                        'operational' => '🟢 Operational',
                        'under_maintenance' => '🔧 Under Maintenance',
                        'degraded' => '⚠️ Degraded',
                        'broken' => '✕ Broken',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->button()
                    ->color('primary')
                    ->icon('heroicon-m-pencil-square'),
                Tables\Actions\DeleteAction::make()
                    ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEquipment::route('/'),
            'create' => Pages\CreateEquipment::route('/create'),
            'edit' => Pages\EditEquipment::route('/{record}/edit'),
        ];
    }
}
