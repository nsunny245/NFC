<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuCategoryResource\Pages;
use App\Models\MenuCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MenuCategoryResource extends Resource
{
    protected static ?string $model = MenuCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'Menu Categories';

    protected static ?string $modelLabel = 'Menu Category';

    protected static ?string $pluralModelLabel = 'Menu Categories';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Category Overview')
                    ->description('Define category title, url slug, and menu display settings.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Category Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Special Flavours Pizza, Royal Karahi'),
                        Forms\Components\TextInput::make('slug')
                            ->label('Web & POS Slug')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. special-flavours-pizza'),
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->placeholder('Brief description for digital menu and online ordering')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Display & Visibility')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active on POS & Digital Menu')
                            ->helperText('When enabled, this category will appear on Cashier POS, Waiter Pad, and Online Explorer.')
                            ->default(true)
                            ->required(),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Menu Sort Order (Priority)')
                            ->helperText('Lower numbers appear first on POS and Waiter tabs.')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Category Name')
                    ->searchable()
                    ->sortable()
                    ->weight('black')
                    ->icon(fn ($record) => match (true) {
                        str_contains(strtolower($record->name), 'pizza') => 'heroicon-m-sparkles',
                        str_contains(strtolower($record->name), 'burger') => 'heroicon-m-fire',
                        str_contains(strtolower($record->name), 'platter') => 'heroicon-m-gift',
                        str_contains(strtolower($record->name), 'doner') => 'heroicon-m-cube',
                        str_contains(strtolower($record->name), 'appetizer') => 'heroicon-m-bolt',
                        str_contains(strtolower($record->name), 'roll') => 'heroicon-m-bookmark',
                        str_contains(strtolower($record->name), 'fries') => 'heroicon-m-star',
                        str_contains(strtolower($record->name), 'karahi') || str_contains(strtolower($record->name), 'handi') => 'heroicon-m-cake',
                        str_contains(strtolower($record->name), 'bbq') || str_contains(strtolower($record->name), 'tikka') => 'heroicon-m-flame',
                        str_contains(strtolower($record->name), 'drink') || str_contains(strtolower($record->name), 'beverage') => 'heroicon-m-beaker',
                        default => 'heroicon-m-tag',
                    })
                    ->iconColor('primary'),

                Tables\Columns\TextColumn::make('menu_items_count')
                    ->counts('menuItems')
                    ->label('Dishes Count')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn ($state) => $state . ' Dishes')
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->fontFamily('mono')
                    ->color('gray')
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Live on Menu')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Priority')
                    ->badge()
                    ->color('warning')
                    ->formatStateUsing(fn ($state) => '#' . $state)
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Visibility')
                    ->boolean()
                    ->trueLabel('Active Categories')
                    ->falseLabel('Hidden Categories'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
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
            'index' => Pages\ListMenuCategories::route('/'),
            'create' => Pages\CreateMenuCategory::route('/create'),
            'edit' => Pages\EditMenuCategory::route('/{record}/edit'),
        ];
    }
}
