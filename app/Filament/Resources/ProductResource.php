<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Productos (Gafas)';

    protected static ?string $pluralModelLabel = 'Productos (Gafas & Lentes)';

    protected static ?string $navigationGroup = 'Catálogo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Información Básica')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nombre del Producto')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug URL')
                                    ->required()
                                    ->unique(Product::class, 'slug', ignoreRecord: true),
                                Forms\Components\TextInput::make('sku')
                                    ->label('SKU / Código')
                                    ->required()
                                    ->default(fn () => 'OPT-' . strtoupper(Str::random(6)))
                                    ->unique(Product::class, 'sku', ignoreRecord: true),
                                Forms\Components\Textarea::make('description')
                                    ->label('Descripción')
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Forms\Components\Section::make('Características del Armazón / Lente')
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->label('Categoría')
                                    ->relationship('category', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\Select::make('brand_id')
                                    ->label('Marca')
                                    ->relationship('brand', 'name')
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\Select::make('frame_type')
                                    ->label('Material de la Montura')
                                    ->options([
                                        'Metal' => 'Metal',
                                        'Acetato' => 'Acetato Premium',
                                        'Titanio' => 'Titanio Ligero',
                                        'Inyectado' => 'Inyectado / Polímero',
                                        'Sin Montura' => 'Sin Montura (Rimless)',
                                    ]),
                                Forms\Components\Select::make('frame_shape')
                                    ->label('Forma de la Montura')
                                    ->options([
                                        'Aviador' => 'Aviador',
                                        'Redonda' => 'Redonda',
                                        'Cuadrada' => 'Cuadrada',
                                        'Cat-Eye' => 'Cat-Eye (Ojo de Gato)',
                                        'Rectangular' => 'Rectangular',
                                        'Ovalada' => 'Ovalada',
                                        'Wayfarer' => 'Wayfarer',
                                    ]),
                                Forms\Components\Select::make('gender')
                                    ->label('Género Target')
                                    ->options([
                                        'Hombre' => 'Hombre',
                                        'Mujer' => 'Mujer',
                                        'Unisex' => 'Unisex',
                                        'Niños' => 'Niños / Infantil',
                                    ])
                                    ->default('Unisex'),
                            ])->columns(2),
                    ])->columnSpan(2),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Precios e Inventario')
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->label('Precio ($)')
                                    ->numeric()
                                    ->prefix('$')
                                    ->required(),
                                Forms\Components\TextInput::make('sale_price')
                                    ->label('Precio Promoción ($)')
                                    ->numeric()
                                    ->prefix('$'),
                                Forms\Components\TextInput::make('stock')
                                    ->label('Inventario (Stock)')
                                    ->numeric()
                                    ->required()
                                    ->default(10),
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Producto Destacado en Inicio')
                                    ->default(false),
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Activo para la venta')
                                    ->default(true),
                            ]),

                        Forms\Components\Section::make('Galería de Fotos')
                            ->schema([
                                Forms\Components\FileUpload::make('images')
                                    ->label('Fotos del Producto')
                                    ->multiple()
                                    ->directory('products')
                                    ->panelLayout('grid'),
                            ]),
                    ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                    ->label('Imagen')
                    ->circular()
                    ->stacked()
                    ->limit(2),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoría')
                    ->sortable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Marca')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Precio')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state <= 2 => 'danger',
                        $state <= 5 => 'warning',
                        default => 'success',
                    }),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Destacado')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Categoría')
                    ->relationship('category', 'name'),
                Tables\Filters\SelectFilter::make('brand_id')
                    ->label('Marca')
                    ->relationship('brand', 'name'),
                Tables\Filters\SelectFilter::make('gender')
                    ->options([
                        'Hombre' => 'Hombre',
                        'Mujer' => 'Mujer',
                        'Unisex' => 'Unisex',
                        'Niños' => 'Niños',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
