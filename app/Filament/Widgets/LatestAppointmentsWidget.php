<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestAppointmentsWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Próximas Citas de Examen de la Vista';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Appointment::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('patient_name')->label('Paciente'),
                Tables\Columns\TextColumn::make('phone')->label('Teléfono'),
                Tables\Columns\TextColumn::make('appointment_date')->label('Fecha')->date('d/m/Y'),
                Tables\Columns\TextColumn::make('time_slot')->label('Hora'),
                Tables\Columns\TextColumn::make('reason')->label('Motivo'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pendiente',
                        'confirmed' => 'Confirmada',
                        'completed' => 'Completada',
                        'cancelled' => 'Cancelada',
                        default => $state,
                    }),
            ]);
    }
}
