<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceLogResource\Pages;
use App\Models\AttendanceLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AttendanceLogResource extends Resource
{
    protected static ?string $model = AttendanceLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationLabel = 'Staff Shift Logs';

    protected static ?string $modelLabel = 'Shift Log';

    protected static ?string $pluralModelLabel = 'Staff Shift Logs';

    protected static ?string $navigationGroup = 'Royal Back-Office RRP';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Shift Details')
                    ->schema([
                        Forms\Components\Select::make('staff_member_id')
                            ->relationship('staffMember', 'full_name')
                            ->searchable()
                            ->required()
                            ->label('Employee'),
                        Forms\Components\DatePicker::make('date')
                            ->required()
                            ->default(now()),
                        Forms\Components\Select::make('status')
                            ->options([
                                'present' => 'Present',
                                'absent' => 'Absent',
                                'late' => 'Late Shift',
                                'leave' => 'Approved Leave',
                            ])
                            ->required()
                            ->default('present'),
                    ])->columns(3),

                Forms\Components\Section::make('Shift Timings')
                    ->schema([
                        Forms\Components\TimePicker::make('check_in')
                            ->required()
                            ->default('09:00:00'),
                        Forms\Components\TimePicker::make('check_out')
                            ->default('18:00:00'),
                        Forms\Components\Textarea::make('notes')
                            ->placeholder('Any shift incidents or handover comments...')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('staffMember.full_name')
                    ->label('Staff Member')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('staffMember.role_designation')
                    ->label('Role')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('date')
                    ->date('M d, Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('check_in')
                    ->label('Clock In')
                    ->dateTime('h:i A')
                    ->placeholder('--:--'),
                Tables\Columns\TextColumn::make('check_out')
                    ->label('Clock Out')
                    ->dateTime('h:i A')
                    ->placeholder('Active Shift'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'present' => 'success',
                        'absent' => 'danger',
                        'late' => 'warning',
                        'leave' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('notes')
                    ->limit(30)
                    ->placeholder('None')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'present' => 'Present',
                        'absent' => 'Absent',
                        'late' => 'Late Shift',
                        'leave' => 'Approved Leave',
                    ]),
                Tables\Filters\Filter::make('today')
                    ->label('Today\'s Shifts')
                    ->query(fn (Builder $query): Builder => $query->whereDate('date', now())),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date', 'desc');
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
            'index' => Pages\ListAttendanceLogs::route('/'),
            'create' => Pages\CreateAttendanceLog::route('/create'),
            'edit' => Pages\EditAttendanceLog::route('/{record}/edit'),
        ];
    }
}
