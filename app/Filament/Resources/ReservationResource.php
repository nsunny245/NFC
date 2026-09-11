<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Filament\Resources\ReservationResource\RelationManagers;
use App\Models\Reservation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('guest_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('guest_phone')
                    ->required()
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('guest_email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('reservation_time')
                    ->required(),
                Forms\Components\TextInput::make('guest_count')
                    ->required()
                    ->numeric()
                    ->default(2),
                Forms\Components\TextInput::make('table_number')
                    ->maxLength(50),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'seated' => 'Seated',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->default('pending'),
                Forms\Components\Textarea::make('special_requests')
                    ->columnSpanFull()
                    ->maxLength(500),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('guest_name')
                    ->label('Royal Guest')
                    ->searchable()
                    ->sortable()
                    ->weight('black')
                    ->icon('heroicon-m-user')
                    ->description(fn (Reservation $record): string => $record->guest_phone . ($record->guest_email ? ' • ' . $record->guest_email : '')),

                Tables\Columns\TextColumn::make('reservation_time')
                    ->label('Booking Schedule')
                    ->dateTime('M d, Y • h:i A')
                    ->weight('bold')
                    ->sortable()
                    ->description(fn (Reservation $record): string => $record->reservation_time ? $record->reservation_time->diffForHumans() : ''),

                Tables\Columns\TextColumn::make('guest_count')
                    ->label('Party Size')
                    ->badge()
                    ->formatStateUsing(fn ($state) => "👥 {$state} Guests")
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('table_number')
                    ->label('Table Assigned')
                    ->badge()
                    ->formatStateUsing(fn ($state) => filled($state) ? "🪑 Table {$state}" : "⚠️ Unassigned")
                    ->color(fn ($state) => filled($state) ? 'success' : 'danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Booking Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => '🟡 Pending Review',
                        'confirmed' => '🟢 Confirmed',
                        'seated' => '🍽️ Seated & Dining',
                        'cancelled' => '✕ Cancelled',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'seated' => 'info',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('special_requests')
                    ->label('Special Requests')
                    ->limit(35)
                    ->default('Standard dining preference')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Booked On')
                    ->dateTime('M d, Y h:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('active_bookings')
                    ->label('Active Bookings Only')
                    ->query(fn (Builder $query) => $query->where('status', '!=', 'cancelled'))
                    ->default(true),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export_all_csv')
                    ->label('Export All (CSV)')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->action(function () {
                        $records = Reservation::all();
                        
                        $headers = [
                            'Content-Type' => 'text/csv',
                            'Content-Disposition' => 'attachment; filename="reservations-all-export-' . now()->format('Y-m-d') . '.csv"',
                        ];

                        $callback = function () use ($records) {
                            $file = fopen('php://output', 'w');
                            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
                            
                            fputcsv($file, [
                                'Reservation ID',
                                'Guest Name',
                                'Guest Phone',
                                'Guest Email',
                                'Reservation Time',
                                'Guest Count',
                                'Table Number',
                                'Status',
                                'Special Requests',
                                'Created At'
                            ]);

                            foreach ($records as $record) {
                                fputcsv($file, [
                                    $record->id,
                                    $record->guest_name,
                                    $record->guest_phone,
                                    $record->guest_email,
                                    $record->reservation_time ? $record->reservation_time->format('Y-m-d H:i:s') : '',
                                    $record->guest_count,
                                    $record->table_number,
                                    ucfirst($record->status),
                                    $record->special_requests,
                                    $record->created_at->format('Y-m-d H:i:s'),
                                ]);
                            }

                            fclose($file);
                        };

                        return response()->stream($callback, 200, $headers);
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('confirm')
                    ->label('Confirm')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->button()
                    ->visible(fn (Reservation $record) => $record->status === 'pending')
                    ->action(function (Reservation $record) {
                        $record->update(['status' => 'confirmed']);
                        \Filament\Notifications\Notification::make()
                            ->title('Reservation Confirmed')
                            ->body("Guest {$record->guest_name}'s booking has been confirmed.")
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('seat')
                    ->label('Seat Guests')
                    ->icon('heroicon-o-arrow-right-end-on-rectangle')
                    ->color('info')
                    ->button()
                    ->visible(fn (Reservation $record) => in_array($record->status, ['pending', 'confirmed']))
                    ->action(function (Reservation $record) {
                        $record->update(['status' => 'seated']);
                        \Filament\Notifications\Notification::make()
                            ->title('Guests Seated')
                            ->body("Guest {$record->guest_name} is now seated at " . ($record->table_number ? "Table {$record->table_number}" : "table") . ".")
                            ->success()
                            ->send();
                    }),
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->button()
                    ->color('primary')
                    ->icon('heroicon-m-pencil-square'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('export_csv')
                        ->label('Export Selected to CSV')
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('success')
                        ->action(function (\Illuminate\Support\Collection $records) {
                            $headers = [
                                'Content-Type' => 'text/csv',
                                'Content-Disposition' => 'attachment; filename="reservations-selected-export-' . now()->format('Y-m-d') . '.csv"',
                            ];

                            $callback = function () use ($records) {
                                $file = fopen('php://output', 'w');
                                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
                                
                                fputcsv($file, [
                                    'Reservation ID',
                                    'Guest Name',
                                    'Guest Phone',
                                    'Guest Email',
                                    'Reservation Time',
                                    'Guest Count',
                                    'Table Number',
                                    'Status',
                                    'Special Requests',
                                    'Created At'
                                ]);

                                foreach ($records as $record) {
                                    fputcsv($file, [
                                        $record->id,
                                        $record->guest_name,
                                        $record->guest_phone,
                                        $record->guest_email,
                                        $record->reservation_time ? $record->reservation_time->format('Y-m-d H:i:s') : '',
                                        $record->guest_count,
                                        $record->table_number,
                                        ucfirst($record->status),
                                        $record->special_requests,
                                        $record->created_at->format('Y-m-d H:i:s'),
                                    ]);
                                }

                                fclose($file);
                            };

                            return response()->stream($callback, 200, $headers);
                        }),
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
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }
}
