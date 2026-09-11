<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuItemResource\Pages;
use App\Models\MenuItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MenuItemResource extends Resource
{
    protected static ?string $model = MenuItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Menu Items';

    protected static ?string $modelLabel = 'Dish';

    protected static ?string $pluralModelLabel = 'Menu Dishes & Recipes';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dish Profile')
                    ->description('Essential menu parameters, pricing, and category mapping.')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Menu Category')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('name')
                            ->label('Dish Title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Royal Chicken Karahi, Special Nawabi Pizza'),
                        Forms\Components\TextInput::make('price')
                            ->label('Base Price (PKR)')
                            ->required()
                            ->numeric()
                            ->prefix('Rs.')
                            ->placeholder('e.g. 1450'),
                        Forms\Components\FileUpload::make('image_path')
                            ->label('Dish Photograph')
                            ->image()
                            ->directory('menu-items')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1'),
                        Forms\Components\Textarea::make('description')
                            ->label('Menu Description')
                            ->placeholder('Ingredients, taste profile, and preparation style')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Availability & Highlights')
                    ->schema([
                        Forms\Components\Toggle::make('is_available')
                            ->label('Available in Stock')
                            ->helperText('Disable if ingredients are depleted to immediately hide from POS/Waiter ordering.')
                            ->default(true)
                            ->required(),
                        Forms\Components\Toggle::make('is_hero_item')
                            ->label('⭐ Chef Special / Hero Dish')
                            ->helperText('Promotes this item to top of the online menu and POS featured drawer.')
                            ->default(false),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Recipe / Ingredient Mapping (Auto-deplete Stocks)')
                    ->description('Map this dish to inventory ingredients so stocks deplete automatically upon order completion.')
                    ->schema([
                        Forms\Components\Repeater::make('recipeItems')
                            ->relationship('recipeItems')
                            ->schema([
                                Forms\Components\Select::make('inventory_item_id')
                                    ->label('Ingredient Name')
                                    ->relationship('inventoryItem', 'name')
                                    ->required()
                                    ->reactive()
                                    ->columnSpan(8),
                                Forms\Components\TextInput::make('required_quantity')
                                    ->label('Qty Required')
                                    ->numeric()
                                    ->required()
                                    ->columnSpan(4),
                            ])
                            ->columns(12)
                            ->label('Ingredients required for 1 portion of this dish'),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Photo')
                    ->circular()
                    ->defaultImageUrl(asset('images/logo_circular.png')),

                Tables\Columns\TextColumn::make('name')
                    ->label('Dish Title')
                    ->searchable()
                    ->sortable()
                    ->weight('black')
                    ->description(fn ($record) => \Illuminate\Support\Str::limit($record->description, 35)),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Price (PKR)')
                    ->formatStateUsing(fn ($state) => 'Rs. ' . number_format($state, 0))
                    ->weight('black')
                    ->color('success')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_available')
                    ->label('In Stock')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\IconColumn::make('is_hero_item')
                    ->label('⭐ Star Dish')
                    ->boolean()
                    ->trueIcon('heroicon-s-star')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('warning')
                    ->falseColor('gray'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_available')
                    ->label('Availability')
                    ->boolean()
                    ->trueLabel('In Stock')
                    ->falseLabel('Out of Stock'),
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
            'index' => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit' => Pages\EditMenuItem::route('/{record}/edit'),
        ];
    }
}
