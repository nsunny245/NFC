<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\Summarizers\Sum;
use Illuminate\Database\Eloquent\Builder;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Expenses Ledger';

    protected static ?string $modelLabel = 'Expense Record';

    protected static ?string $pluralModelLabel = 'Expenses Ledger';

    protected static ?string $navigationGroup = 'Royal Back-Office RRP';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Transaction Core')
                    ->schema([
                        Forms\Components\Select::make('category')
                            ->options([
                                'utility' => 'Utilities (Power/Gas/Water)',
                                'rent' => 'Property Rent',
                                'inventory_procurement' => 'Inventory Procurement',
                                'marketing' => 'Marketing & Ads',
                                'salaries' => 'Staff Payroll / Bonus',
                                'maintenance' => 'Repairs & Maintenance',
                                'other' => 'Other Overhead Expenses',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('amount')
                            ->label('Amount Spent')
                            ->required()
                            ->numeric()
                            ->prefix('Rs.')
                            ->placeholder('e.g. 15000'),
                        Forms\Components\DatePicker::make('expense_date')
                            ->label('Expense Date')
                            ->required()
                            ->default(now()),
                    ])->columns(3),

                Forms\Components\Section::make('Payee & Supporting Documents')
                    ->schema([
                        Forms\Components\TextInput::make('recipient')
                            ->label('Paid To (Recipient)')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Okara Gas Suppliers'),
                        Forms\Components\TextInput::make('invoice_number')
                            ->label('Invoice / Voucher #')
                            ->maxLength(255)
                            ->placeholder('e.g. INV-9921')
                            ->default(null),
                        Forms\Components\FileUpload::make('receipt_path')
                            ->label('Upload Receipt Receipt/Invoice')
                            ->directory('receipts')
                            ->image()
                            ->maxSize(2048) // 2MB
                            ->default(null),
                        Forms\Components\Textarea::make('description')
                            ->placeholder('Provide any contextual details about this transaction...')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('expense_date')
                    ->label('Date')
                    ->date('M d, Y')
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('category')
                    ->label('Expense Head')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'utility' => '⚡ Utilities (Gas/Power)',
                        'rent' => '🏢 Property Rent',
                        'inventory_procurement' => '📦 Stock Procurement',
                        'salaries' => '👨‍🍳 Staff Payroll',
                        'maintenance' => '🔧 Repairs & Upkeep',
                        'marketing' => '📢 Marketing & Ads',
                        default => '🏷️ Other Overhead',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'utility' => 'warning',
                        'rent' => 'danger',
                        'inventory_procurement' => 'info',
                        'salaries' => 'success',
                        'maintenance' => 'primary',
                        default => 'gray',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('recipient')
                    ->label('Paid To')
                    ->icon('heroicon-m-building-storefront')
                    ->searchable(),
                Tables\Columns\TextColumn::make('invoice_number')
                    ->label('Voucher #')
                    ->searchable()
                    ->placeholder('N/A')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount (PKR)')
                    ->weight('black')
                    ->color('danger')
                    ->formatStateUsing(fn ($state) => 'Rs. ' . number_format($state, 2))
                    ->sortable()
                    ->summarize(Sum::make()->label('Total Expenses')->formatStateUsing(fn ($state) => 'Rs. ' . number_format($state, 2))),
                Tables\Columns\TextColumn::make('description')
                    ->label('Remarks')
                    ->limit(45)
                    ->placeholder('No remarks recorded'),
                Tables\Columns\ImageColumn::make('receipt_path')
                    ->label('Receipt')
                    ->disk('public')
                    ->circular()
                    ->placeholder('No File')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'utility' => '⚡ Utilities',
                        'rent' => '🏢 Property Rent',
                        'inventory_procurement' => '📦 Inventory Procurement',
                        'salaries' => '👨‍🍳 Staff Salaries',
                        'marketing' => '📢 Marketing',
                        'maintenance' => '🔧 Repairs',
                        'other' => '🏷️ Other',
                    ]),
                Tables\Filters\Filter::make('this_month')
                    ->label('This Month\'s Bills')
                    ->query(fn (Builder $query): Builder => $query->whereMonth('expense_date', now()->month)->whereYear('expense_date', now()->year)),
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
            ->defaultSort('expense_date', 'desc');
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
