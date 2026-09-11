<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Royal Back-Office RRP';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50),
                        Forms\Components\Textarea::make('address')
                            ->maxLength(65535)
                            ->rows(3)
                            ->placeholder('Compulsory for Delivery orders')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Customer Name')
                    ->searchable()
                    ->sortable()
                    ->weight('black')
                    ->icon('heroicon-m-user')
                    ->description(fn (Customer $record): string => 'Registered ' . $record->created_at->format('M d, Y')),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Contact Phone')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Phone number copied')
                    ->fontFamily('mono')
                    ->icon('heroicon-m-phone'),

                Tables\Columns\TextColumn::make('address')
                    ->label('Delivery Address')
                    ->limit(45)
                    ->default('Walk-in / In-Store Guest')
                    ->icon('heroicon-m-map-pin')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created On')
                    ->dateTime('M d, Y h:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCustomers::route('/'),
        ];
    }
}
