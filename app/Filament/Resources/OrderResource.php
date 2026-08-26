<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationLabel = 'Pedidos';

    protected static ?string $pluralModelLabel = 'Pedidos de Venta';

    protected static ?string $navigationGroup = 'Ventas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Información del Pedido')
                            ->schema([
                                Forms\Components\TextInput::make('order_number')
                                    ->label('Número de Pedido')
                                    ->required()
                                    ->default(fn () => 'ORD-' . strtoupper(Str::random(8)))
                                    ->readOnly(),
                                Forms\Components\Select::make('user_id')
                                    ->label('Cliente Registrado')
                                    ->relationship('user', 'name')
                                    ->searchable(),
                                Forms\Components\TextInput::make('customer_name')
                                    ->label('Nombre del Cliente')
                                    ->required(),
                                Forms\Components\TextInput::make('email')
                                    ->label('Correo Electrónico')
                                    ->email()
                                    ->required(),
                                Forms\Components\TextInput::make('phone')
                                    ->label('Teléfono')
                                    ->required(),
                                Forms\Components\Select::make('prescription_id')
                                    ->label('Receta Óptica Adjunta')
                                    ->relationship('prescription', 'patient_name')
                                    ->searchable()
                                    ->placeholder('Ninguna (Solo armazón o sol)'),
                                Forms\Components\Textarea::make('shipping_address')
                                    ->label('Dirección de Envío')
                                    ->required()
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Forms\Components\Section::make('Artículos del Pedido')
                            ->schema([
                                Forms\Components\Repeater::make('items')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\Select::make('product_id')
                                            ->label('Producto')
                                            ->options(Product::pluck('name', 'id'))
                                            ->required()
                                            ->reactive()
                                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('unit_price', Product::find($state)?->price ?? 0)),
                                        Forms\Components\TextInput::make('quantity')
                                            ->label('Cantidad')
                                            ->numeric()
                                            ->default(1)
                                            ->required()
                                            ->reactive()
                                            ->afterStateUpdated(fn ($state, Forms\Get $get, Forms\Set $set) => $set('total_price', $state * $get('unit_price'))),
                                        Forms\Components\TextInput::make('unit_price')
                                            ->label('Precio Unitario ($)')
                                            ->numeric()
                                            ->prefix('$')
                                            ->required(),
                                        Forms\Components\TextInput::make('total_price')
                                            ->label('Total ($)')
                                            ->numeric()
                                            ->prefix('$')
                                            ->required(),
                                    ])->columns(4),
                            ]),
                    ])->columnSpan(2),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Estado y Monto')
                            ->schema([
                                Forms\Components\TextInput::make('total_amount')
                                    ->label('Monto Total ($)')
                                    ->numeric()
                                    ->prefix('$')
                                    ->required(),
                                Forms\Components\Select::make('status')
                                    ->label('Estado del Pedido')
                                    ->options([
                                        'pending' => 'Pendiente',
                                        'processing' => 'En Preparación (Taller Óptico)',
                                        'shipped' => 'Enviado',
                                        'delivered' => 'Entregado',
                                        'cancelled' => 'Cancelado',
                                    ])
                                    ->default('pending')
                                    ->required(),
                                Forms\Components\Select::make('payment_status')
                                    ->label('Estado de Pago')
                                    ->options([
                                        'unpaid' => 'No Pagado',
                                        'paid' => 'Pagado',
                                        'refunded' => 'Reembolsado',
                                    ])
                                    ->default('unpaid')
                                    ->required(),
                                Forms\Components\Textarea::make('notes')
                                    ->label('Notas del Pedido'),
                            ]),
                    ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('Nº Pedido')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Cliente')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'processing' => 'info',
                        'shipped' => 'primary',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pendiente',
                        'processing' => 'Taller Óptico',
                        'shipped' => 'Enviado',
                        'delivered' => 'Entregado',
                        'cancelled' => 'Cancelado',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Pago')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'unpaid' => 'danger',
                        'paid' => 'success',
                        'refunded' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'unpaid' => 'No Pagado',
                        'paid' => 'Pagado',
                        'refunded' => 'Reembolsado',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pendiente',
                        'processing' => 'En Preparación',
                        'shipped' => 'Enviado',
                        'delivered' => 'Entregado',
                        'cancelled' => 'Cancelado',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('syncToOdoo')
                    ->label('Enviar a Odoo (SO)')
                    ->icon('heroicon-o-cloud-arrow-up')
                    ->color('success')
                    ->action(function (Order $record) {
                        $odooService = app(\App\Services\OdooService::class);
                        $res = $odooService->createSaleOrder($record);

                        if ($res['success'] ?? false) {
                            \Filament\Notifications\Notification::make()
                                ->title('Enviado a Odoo API')
                                ->body($res['message'] ?? 'Orden de Venta creada exitosamente.')
                                ->success()
                                ->send();
                        } else {
                            \Filament\Notifications\Notification::make()
                                ->title('Error en Sincronización')
                                ->body($res['error'] ?? 'Ocurrió un inconveniente.')
                                ->danger()
                                ->send();
                        }
                    }),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
