<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryItemResource\Pages;
use App\Models\InventoryItem;
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;

class InventoryItemResource extends Resource
{
    protected static ?string $model = InventoryItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationLabel = 'Inventory Stocks';

    protected static ?string $modelLabel = 'Inventory Stock';

    protected static ?string $pluralModelLabel = 'Inventory Stocks';

    protected static ?string $navigationGroup = 'Royal Back-Office RRP';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('General Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Royal Mutton Leg'),
                        Forms\Components\TextInput::make('sku')
                            ->label('SKU Reference')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. INV-MUT-001')
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('category')
                            ->options([
                                'meats' => 'Meats (Mutton/Chicken)',
                                'dry_goods' => 'Dry Goods (Rice/Flour)',
                                'dairy' => 'Dairy & Oils',
                                'vegetables' => 'Fresh Vegetables',
                                'beverages' => 'Beverages & Soft Drinks',
                                'packaging' => 'Packaging (Tins/Boxes)',
                                'other' => 'Other Raw Materials',
                            ])
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Stock Control')
                    ->schema([
                        Forms\Components\TextInput::make('quantity')
                            ->label('Current In-Stock Quantity')
                            ->required()
                            ->numeric()
                            ->default(0.00),
                        Forms\Components\TextInput::make('unit')
                            ->label('Unit of Measurement')
                            ->required()
                            ->maxLength(50)
                            ->placeholder('e.g. kg, piece, liter'),
                        Forms\Components\TextInput::make('minimum_qty')
                            ->label('Minimum Stock Alert Threshold')
                            ->required()
                            ->numeric()
                            ->default(10.00),
                    ])->columns(3),

                Forms\Components\Section::make('Costing & Supplier Registry')
                    ->schema([
                        Forms\Components\TextInput::make('unit_cost')
                            ->label('Cost per Unit')
                            ->required()
                            ->numeric()
                            ->prefix('Rs.')
                            ->default(0.00),
                        Forms\Components\TextInput::make('supplier_name')
                            ->label('Preferred Supplier')
                            ->placeholder('e.g. Lahore Meat Hub')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\DateTimePicker::make('last_restocked_at')
                            ->label('Last Restocked Date')
                            ->disabled()
                            ->dehydrated(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Item Name')
                    ->searchable()
                    ->sortable()
                    ->weight('black')
                    ->icon('heroicon-m-archive-box')
                    ->description(fn (InventoryItem $record): string => "SKU: {$record->sku}"),

                Tables\Columns\TextColumn::make('category')
                    ->label('Category')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'meats' => '🥩 Meats',
                        'dry_goods' => '🍚 Dry Goods',
                        'dairy' => '🥛 Dairy & Oils',
                        'vegetables' => '🥬 Fresh Produce',
                        'beverages' => '🥤 Beverages',
                        'packaging' => '📦 Packaging',
                        default => '🏷️ ' . ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'meats' => 'danger',
                        'dry_goods' => 'warning',
                        'dairy' => 'info',
                        'vegetables' => 'success',
                        'beverages' => 'gray',
                        'packaging' => 'primary',
                        default => 'gray',
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Stock Level')
                    ->numeric(2)
                    ->sortable()
                    ->weight('black')
                    ->color(fn (InventoryItem $record): string => $record->quantity <= $record->minimum_qty ? 'danger' : 'success')
                    ->formatStateUsing(fn ($state, InventoryItem $record) => number_format((float) $state, 2) . ' ' . $record->unit)
                    ->description(fn (InventoryItem $record): string => 'Alert below: ' . number_format((float) $record->minimum_qty, 2) . ' ' . $record->unit),

                Tables\Columns\TextColumn::make('status')
                    ->label('Health')
                    ->badge()
                    ->state(fn (InventoryItem $record): string => $record->quantity <= $record->minimum_qty ? 'Low Stock' : 'Healthy')
                    ->formatStateUsing(fn (string $state): string => $state === 'Low Stock' ? '⚠️ Low Stock' : '🟢 Healthy')
                    ->color(fn (string $state): string => $state === 'Low Stock' ? 'danger' : 'success'),

                Tables\Columns\TextColumn::make('unit_cost')
                    ->label('Cost / Unit')
                    ->formatStateUsing(fn ($state) => 'Rs. ' . number_format((float) $state, 2))
                    ->weight('bold')
                    ->sortable(),

                Tables\Columns\TextColumn::make('supplier_name')
                    ->label('Supplier')
                    ->searchable()
                    ->icon('heroicon-m-building-storefront')
                    ->default('Local Wholesale Market'),

                Tables\Columns\TextColumn::make('last_restocked_at')
                    ->label('Last Restocked')
                    ->dateTime('M d, Y • h:i A')
                    ->sortable()
                    ->placeholder('Never restocked')
                    ->description(fn (InventoryItem $record): ?string => $record->last_restocked_at ? $record->last_restocked_at->diffForHumans() : null),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'meats' => '🥩 Meats',
                        'dry_goods' => '🍚 Dry Goods',
                        'dairy' => '🥛 Dairy & Oils',
                        'vegetables' => '🥬 Fresh Vegetables',
                        'beverages' => '🥤 Beverages',
                        'packaging' => '📦 Packaging',
                        'other' => '🏷️ Other',
                    ]),
                Tables\Filters\Filter::make('low_stock')
                    ->label('Low Stock Warning')
                    ->query(fn (Builder $query): Builder => $query->whereColumn('quantity', '<=', 'minimum_qty')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->button()
                    ->color('primary')
                    ->icon('heroicon-m-pencil-square'),

                // RESTOCK ACTION: Integrates stock procurement directly into Expense ledger
                Action::make('restock')
                    ->label('Restock')
                    ->icon('heroicon-m-plus-circle')
                    ->button()
                    ->color('warning')
                    ->modalHeading(fn (InventoryItem $record) => "Procure & Restock: {$record->name}")
                    ->modalDescription('Add new stock batch and automatically record procurement expense in the financial ledger.')
                    ->modalSubmitActionLabel('Confirm Restock & Log Expense')
                    ->form([
                        Forms\Components\TextInput::make('add_quantity')
                            ->label('Quantity to Add')
                            ->helperText(fn (InventoryItem $record) => "Current in-stock: {$record->quantity} {$record->unit}")
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('cost_per_unit')
                            ->label('Cost per Unit')
                            ->required()
                            ->numeric()
                            ->prefix('Rs.')
                            ->default(fn (InventoryItem $record) => $record->unit_cost),
                        Forms\Components\TextInput::make('supplier_name')
                            ->label('Supplier / Vendor Name')
                            ->required()
                            ->default(fn (InventoryItem $record) => $record->supplier_name ?: 'Local Wholesale Market'),
                    ])
                    ->action(function (InventoryItem $record, array $data): void {
                        $addQty = (float) $data['add_quantity'];
                        $costUnit = (float) $data['cost_per_unit'];
                        $totalCost = $addQty * $costUnit;

                        // 1. Update Inventory Item
                        $record->increment('quantity', $addQty);
                        $record->update([
                            'unit_cost' => $costUnit,
                            'supplier_name' => $data['supplier_name'],
                            'last_restocked_at' => now(),
                        ]);

                        // 2. Create automatic Expense record
                        Expense::create([
                            'category' => 'inventory_procurement',
                            'amount' => $totalCost,
                            'expense_date' => now()->format('Y-m-d'),
                            'recipient' => $data['supplier_name'],
                            'description' => "Restocked {$addQty} {$record->unit} of '{$record->name}' (SKU: {$record->sku}) at Rs. {$costUnit}/unit.",
                        ]);

                        \Filament\Notifications\Notification::make()
                            ->title('Stock Procured & Logged')
                            ->body("Added {$addQty} {$record->unit} to {$record->name}. Procurement expense of Rs. " . number_format($totalCost) . " logged.")
                            ->success()
                            ->send();
                    }),

                Tables\Actions\DeleteAction::make()
                    ->label('Delete')
                    ->button()
                    ->color('danger')
                    ->icon('heroicon-m-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListInventoryItems::route('/'),
            'create' => Pages\CreateInventoryItem::route('/create'),
            'edit' => Pages\EditInventoryItem::route('/{record}/edit'),
        ];
    }
}
