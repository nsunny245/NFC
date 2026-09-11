<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\MenuItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationLabel = 'Cashier POS / Orders';

    protected static ?string $modelLabel = 'Order';

    protected static ?string $pluralModelLabel = 'Cashier POS & Orders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Customer Profile')
                    ->description('Enter contact information for order synchronization')
                    ->schema([
                        Forms\Components\TextInput::make('customer_name')
                            ->label('Customer Name')
                            ->placeholder('Royal Guest Name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('customer_phone')
                            ->label('Contact Number')
                            ->placeholder('e.g. 03118484987')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('customer_address')
                            ->label('Delivery Address')
                            ->placeholder('Okara City Address (if delivery)')
                            ->columnSpanFull()
                            ->maxLength(500),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Order Setup')
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->label('Order Reference')
                            ->required()
                            ->maxLength(255)
                            ->default(fn () => 'ND-POS-' . strtoupper(bin2hex(random_bytes(3)))),
                        Forms\Components\Select::make('type')
                            ->label('Order Type')
                            ->options([
                                'dine_in' => 'Dine In',
                                'takeaway' => 'Takeaway',
                                'delivery' => 'Delivery',
                            ])
                            ->required()
                            ->default('takeaway')
                            ->reactive(),
                        Forms\Components\Select::make('status')
                            ->label('Order Status')
                            ->options([
                                'pending' => 'Pending',
                                'preparing' => 'Preparing',
                                'ready' => 'Ready',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required()
                            ->default('pending'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Royal Feast Dishes (POS Drawer)')
                    ->description('Select dishes and quantities. Prices are loaded dynamically.')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->relationship('items')
                            ->schema([
                                Forms\Components\Select::make('menu_item_id')
                                    ->label('Dish Name')
                                    ->relationship('menuItem', 'name')
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                        $item = MenuItem::find($state);
                                        if ($item) {
                                            $set('unit_price', $item->price);
                                            $set('quantity', 1);
                                            $set('total_price', $item->price);
                                        }
                                    })
                                    ->columnSpan(4),
                                Forms\Components\TextInput::make('quantity')
                                    ->label('Qty')
                                    ->numeric()
                                    ->default(1)
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        $unitPrice = (float) $get('unit_price');
                                        $quantity = (int) $state;
                                        $set('total_price', $unitPrice * $quantity);
                                    })
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('unit_price')
                                    ->label('Price per Unit')
                                    ->numeric()
                                    ->prefix('Rs.')
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        $unitPrice = (float) $state;
                                        $quantity = (int) $get('quantity');
                                        $set('total_price', $unitPrice * $quantity);
                                    })
                                    ->columnSpan(3),
                                Forms\Components\TextInput::make('total_price')
                                    ->label('Sub-total')
                                    ->numeric()
                                    ->prefix('Rs.')
                                    ->required()
                                    ->disabled()
                                    ->dehydrated()
                                    ->columnSpan(3),
                            ])
                            ->columns(12)
                            ->reactive()
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                                $items = $get('items') ?? [];
                                $subtotal = 0;
                                foreach ($items as $item) {
                                    $subtotal += (float) ($item['total_price'] ?? 0);
                                }
                                $tax = (float) $get('tax');
                                $discount = (float) $get('discount');
                                $total = $subtotal + $tax - $discount;

                                $set('subtotal', $subtotal);
                                $set('total', $total);
                            })
                            ->columnSpanFull()
                            ->label('Dishes to Add'),
                    ]),

                Forms\Components\Section::make('Pricing & Auto-Calculations')
                    ->schema([
                        Forms\Components\TextInput::make('subtotal')
                            ->required()
                            ->numeric()
                            ->prefix('Rs.')
                            ->default(0)
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\TextInput::make('tax')
                            ->required()
                            ->numeric()
                            ->prefix('Rs.')
                            ->default(0)
                            ->reactive()
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                $subtotal = (float) $get('subtotal');
                                $discount = (float) $get('discount');
                                $tax = (float) $state;
                                $set('total', $subtotal + $tax - $discount);
                            }),
                        Forms\Components\TextInput::make('discount')
                            ->required()
                            ->numeric()
                            ->prefix('Rs.')
                            ->default(0)
                            ->reactive()
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                $subtotal = (float) $get('subtotal');
                                $tax = (float) $get('tax');
                                $discount = (float) $state;
                                $set('total', $subtotal + $tax - $discount);
                            }),
                        Forms\Components\TextInput::make('total')
                            ->required()
                            ->numeric()
                            ->prefix('Rs.')
                            ->default(0)
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->columns(4),

                Forms\Components\Textarea::make('special_notes')
                    ->label('POS / Kitchen Comments')
                    ->columnSpanFull()
                    ->maxLength(500),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Order reference copied')
                    ->weight('black')
                    ->fontFamily('mono')
                    ->description(fn (Order $record): string => $record->created_at ? $record->created_at->format('M d • h:i A') : ''),

                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Guest / Customer')
                    ->searchable()
                    ->sortable()
                    ->default('Walk-in Guest')
                    ->weight('bold')
                    ->icon('heroicon-m-user')
                    ->description(fn (Order $record): ?string => $record->customer_phone ?: ($record->type === 'dine_in' ? 'Table Service' : 'Walk-in Counter')),

                Tables\Columns\TextColumn::make('type')
                    ->label('Service Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'dine_in' => '🍽️ Dine-In',
                        'takeaway' => '🛍️ Takeaway',
                        'delivery' => '🛵 Delivery',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'dine_in' => 'info',
                        'takeaway' => 'warning',
                        'delivery' => 'success',
                        default => 'gray',
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('table_number')
                    ->label('Table')
                    ->badge()
                    ->formatStateUsing(fn ($state, Order $record): string => filled($state) ? "🪑 Table {$state}" : ($record->type === 'dine_in' ? '⚠️ Unassigned' : '—'))
                    ->color(fn ($state, Order $record): string => filled($state) ? 'primary' : ($record->type === 'dine_in' ? 'danger' : 'gray'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Order Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => '🟡 Pending',
                        'preparing' => '🔥 In Kitchen',
                        'ready' => '🔔 Ready',
                        'completed' => '✓ Completed',
                        'cancelled' => '✕ Cancelled',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'preparing' => 'warning',
                        'ready' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Payment')
                    ->badge()
                    ->formatStateUsing(fn (?string $state, Order $record): string => 
                        ($state === 'paid' ? '💳 Paid' : '⏳ Unpaid') . 
                        ($record->payment_method ? ' • ' . ucfirst($record->payment_method) : '')
                    )
                    ->color(fn (?string $state): string => match ($state) {
                        'paid' => 'success',
                        default => 'warning',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('total')
                    ->label('Total (PKR)')
                    ->formatStateUsing(fn ($state) => 'Rs. ' . number_format($state, 0))
                    ->weight('black')
                    ->color('success')
                    ->description(fn (Order $record): string => $record->items()->count() . ' dishes')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Placed At')
                    ->dateTime('M d, Y h:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Service Type')
                    ->options([
                        'dine_in' => '🍽️ Dine-In',
                        'takeaway' => '🛍️ Takeaway',
                        'delivery' => '🛵 Delivery',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Order Status')
                    ->options([
                        'pending' => '🟡 Pending',
                        'preparing' => '🔥 In Kitchen',
                        'ready' => '🔔 Ready',
                        'completed' => '✓ Completed',
                        'cancelled' => '✕ Cancelled',
                    ]),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('Payment Status')
                    ->options([
                        'paid' => '💳 Paid',
                        'unpaid' => '⏳ Unpaid',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('thermal_receipt')
                    ->label('Thermal Receipt')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->button()
                    ->modalHeading(fn (Order $record) => "🖨️ Official POS Thermal Ticket #{$record->order_number}")
                    ->modalContent(fn (Order $record) => view('filament.modals.order-thermal-modal', ['order' => $record]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),
                Tables\Actions\Action::make('view_bill')
                    ->label('View Bill')
                    ->icon('heroicon-o-document-text')
                    ->color('info')
                    ->button()
                    ->modalHeading(fn (Order $record) => "Royal Order Summary #{$record->order_number}")
                    ->modalContent(fn (Order $record) => view('filament.modals.order-summary', ['order' => $record]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close Slip'),
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->button()
                    ->color('primary')
                    ->icon('heroicon-m-pencil-square'),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
