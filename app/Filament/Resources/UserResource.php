<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    protected static ?string $navigationLabel = 'Terminals & User Logins';

    protected static ?string $modelLabel = 'Terminal / User Account';

    protected static ?string $pluralModelLabel = 'Terminals & User Accounts';

    protected static ?string $navigationGroup = 'Royal Back-Office RRP';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Account & Role Setup')
                    ->description('Define user identity, system role, and terminal assignment')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Full Name / Terminal Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Counter Cashier 1 or Waiter Hamza'),

                        Forms\Components\TextInput::make('email')
                            ->label('Login Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('e.g. cashier1@nawabidera.com'),

                        Forms\Components\Select::make('role')
                            ->label('System Role')
                            ->options([
                                'cashier' => '🖥️ Cashier (POS Terminal)',
                                'waiter' => '📱 Waiter (Mobile Pad)',
                                'admin' => '👑 Admin (Back Office Management)',
                            ])
                            ->required()
                            ->default('cashier')
                            ->live(),

                        Forms\Components\TextInput::make('terminal_code')
                            ->label('POS Terminal Identifier')
                            ->placeholder('e.g. POS-01, POS-02')
                            ->helperText('Unique terminal identifier used for offline receipt prefixes and machine tracking.')
                            ->maxLength(30)
                            ->default(fn () => 'POS-' . str_pad((string)(User::where('role', 'cashier')->count() + 1), 2, '0', STR_PAD_LEFT)),

                        Forms\Components\TextInput::make('phone')
                            ->label('Contact Phone')
                            ->tel()
                            ->maxLength(30)
                            ->placeholder('e.g. 0311-1234567'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active System Account')
                            ->helperText('Deactivating immediately revokes terminal login and sync access.')
                            ->default(true)
                            ->inline(false),
                    ])->columns(2),

                Forms\Components\Section::make('Security Credentials & Offline PIN')
                    ->description('Set secure login password and quick terminal switch PIN')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label('Login Password')
                            ->password()
                            ->revealable()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->maxLength(255)
                            ->placeholder('Enter secret password...'),

                        Forms\Components\TextInput::make('pin')
                            ->label('Quick Switch PIN (4-6 Digits)')
                            ->numeric()
                            ->maxLength(6)
                            ->helperText('Optional numeric PIN for instant cashier till unlocking and fast shift handover.')
                            ->placeholder('e.g. 1234'),

                        Forms\Components\TextInput::make('api_token')
                            ->label('Dedicated Cloud Sync API Token')
                            ->helperText('Used by the Standalone Desktop POS application to securely sync offline orders to Cloud.')
                            ->default(fn () => Str::random(40))
                            ->readOnly()
                            ->suffixAction(
                                Forms\Components\Actions\Action::make('generateToken')
                                    ->icon('heroicon-m-arrow-path')
                                    ->tooltip('Regenerate Token')
                                    ->action(fn (Forms\Set $set) => $set('api_token', 'nfc_' . Str::random(36)))
                            )
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name / Terminal')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->colors([
                        'warning' => 'admin',
                        'info' => 'cashier',
                        'success' => 'waiter',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'admin' => '👑 Admin',
                        'cashier' => '🖥️ Cashier',
                        'waiter' => '📱 Waiter',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('terminal_code')
                    ->label('Terminal Code')
                    ->badge()
                    ->color('gray')
                    ->placeholder('None')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Login Email')
                    ->searchable()
                    ->copyable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('pin')
                    ->label('Quick PIN')
                    ->badge()
                    ->color('amber')
                    ->placeholder('Not set')
                    ->formatStateUsing(fn ($state) => $state ? 'PIN: ' . $state : '—'),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active Status')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered')
                    ->dateTime('M d, Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'cashier' => 'Cashier Terminals',
                        'waiter' => 'Waiter Mobile Pads',
                        'admin' => 'Administrators',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Terminals Only'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
