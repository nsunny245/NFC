<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StaffMemberResource\Pages;
use App\Models\StaffMember;
use App\Models\AttendanceLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;

class StaffMemberResource extends Resource
{
    protected static ?string $model = StaffMember::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Staff Profiles';

    protected static ?string $modelLabel = 'Staff Profile';

    protected static ?string $pluralModelLabel = 'Staff Profiles';

    protected static ?string $navigationGroup = 'Royal Back-Office RRP';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('General Profile')
                    ->schema([
                        Forms\Components\TextInput::make('full_name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Waqas Khan'),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. 0313-9876543'),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255)
                            ->placeholder('e.g. waiter@nawabidera.com')
                            ->default(null),
                    ])->columns(3),

                Forms\Components\Section::make('Employment Parameters')
                    ->schema([
                        Forms\Components\Select::make('role_designation')
                            ->options([
                                'manager' => 'General Manager',
                                'cashier' => 'Cashier',
                                'waiter' => 'Serving Waiter',
                                'chef' => 'Culinary Chef',
                                'rider' => 'Delivery Rider',
                                'cleaner' => 'Support Staff',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('salary')
                            ->required()
                            ->numeric()
                            ->prefix('Rs.')
                            ->placeholder('Monthly Fixed Salary'),
                        Forms\Components\DatePicker::make('hire_date')
                            ->required()
                            ->default(now()),
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ])
                            ->required()
                            ->default('active'),
                        Forms\Components\Select::make('user_id')
                            ->label('Linked System Login')
                            ->relationship('user', 'name', fn (Builder $query) => $query->whereIn('role', ['cashier', 'waiter', 'admin']))
                            ->placeholder('No system account')
                            ->default(null),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('role_designation')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'manager' => 'danger',
                        'cashier' => 'warning',
                        'waiter' => 'info',
                        'chef' => 'success',
                        'rider' => 'gray',
                        default => 'gray',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('salary')
                    ->label('Salary')
                    ->formatStateUsing(fn ($state) => 'Rs. ' . number_format($state, 0))
                    ->sortable(),
                Tables\Columns\TextColumn::make('hire_date')
                    ->label('Hire Date')
                    ->date('M d, Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'active' ? 'success' : 'danger')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('System User')
                    ->placeholder('No Login Link')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role_designation')
                    ->label('Designation')
                    ->options([
                        'manager' => 'General Manager',
                        'cashier' => 'Cashier',
                        'waiter' => 'Serving Waiter',
                        'chef' => 'Culinary Chef',
                        'rider' => 'Delivery Rider',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->button()
                    ->color('primary')
                    ->icon('heroicon-m-pencil-square'),
                // LOG ATTENDANCE QUICK ACTION
                Action::make('log_attendance')
                    ->label('Log Attendance')
                    ->icon('heroicon-m-clock')
                    ->button()
                    ->color('success')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->label('Attendance Status')
                            ->options([
                                'present' => 'Present',
                                'absent' => 'Absent',
                                'late' => 'Late Shift',
                                'leave' => 'Approved Leave',
                            ])
                            ->required()
                            ->default('present'),
                        Forms\Components\TimePicker::make('check_in')
                            ->label('Check-In Time')
                            ->required()
                            ->default('09:00:00'),
                        Forms\Components\TimePicker::make('check_out')
                            ->label('Check-Out Time')
                            ->default('18:00:00'),
                        Forms\Components\Textarea::make('notes')
                            ->placeholder('Special remarks...')
                            ->maxLength(255),
                    ])
                    ->action(function (StaffMember $record, array $data): void {
                        $today = now()->format('Y-m-d');

                        // Prevent duplicate logs for the same day
                        $existing = AttendanceLog::where('staff_member_id', $record->id)
                            ->whereDate('date', $today)
                            ->first();

                        if ($existing) {
                            $existing->update([
                                'status' => $data['status'],
                                'check_in' => $data['check_in'],
                                'check_out' => $data['check_out'],
                                'notes' => $data['notes'],
                            ]);
                            $msg = "Attendance updated for today.";
                        } else {
                            AttendanceLog::create([
                                'staff_member_id' => $record->id,
                                'date' => $today,
                                'status' => $data['status'],
                                'check_in' => $data['check_in'],
                                'check_out' => $data['check_out'],
                                'notes' => $data['notes'],
                            ]);
                            $msg = "Attendance logged successfully for today.";
                        }

                        \Filament\Notifications\Notification::make()
                            ->title($msg)
                            ->success()
                            ->send();
                    }),
                Tables\Actions\DeleteAction::make()
                    ->button(),
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
            'index' => Pages\ListStaffMembers::route('/'),
            'create' => Pages\CreateStaffMember::route('/create'),
            'edit' => Pages\EditStaffMember::route('/{record}/edit'),
        ];
    }
}
