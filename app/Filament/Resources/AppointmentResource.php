<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Citas de Examen';

    protected static ?string $pluralModelLabel = 'Citas para Examen de la Vista';

    protected static ?string $navigationGroup = 'Clínica & Salud Visual';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos del Paciente')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Usuario Registrado')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('patient_name')
                            ->label('Nombre del Paciente')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label('Correo Electrónico')
                            ->email()
                            ->required(),
                        Forms\Components\TextInput::make('phone')
                            ->label('Teléfono de Contacto')
                            ->tel()
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Programación de la Cita')
                    ->schema([
                        Forms\Components\DatePicker::make('appointment_date')
                            ->label('Fecha de la Cita')
                            ->required()
                            ->default(now()),
                        Forms\Components\Select::make('time_slot')
                            ->label('Horario disponible')
                            ->options([
                                '09:00 AM' => '09:00 AM',
                                '10:00 AM' => '10:00 AM',
                                '11:00 AM' => '11:00 AM',
                                '12:00 PM' => '12:00 PM',
                                '03:00 PM' => '03:00 PM',
                                '04:00 PM' => '04:00 PM',
                                '05:00 PM' => '05:00 PM',
                                '06:00 PM' => '06:00 PM',
                            ])
                            ->required(),
                        Forms\Components\Select::make('optometrist_id')
                            ->label('Optometrista Asignado')
                            ->options(fn () => User::whereIn('role', ['optometrist', 'admin'])->pluck('name', 'id'))
                            ->searchable(),
                        Forms\Components\Select::make('status')
                            ->label('Estado de la Cita')
                            ->options([
                                'pending' => 'Pendiente',
                                'confirmed' => 'Confirmada',
                                'completed' => 'Completada',
                                'cancelled' => 'Cancelada',
                            ])
                            ->default('pending')
                            ->required(),
                        Forms\Components\TextInput::make('reason')
                            ->label('Motivo de Consulta')
                            ->default('Examen visual completo')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('notes')
                            ->label('Notas Internas')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient_name')
                    ->label('Paciente')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable(),
                Tables\Columns\TextColumn::make('appointment_date')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('time_slot')
                    ->label('Hora'),
                Tables\Columns\TextColumn::make('optometrist.name')
                    ->label('Optometrista')
                    ->placeholder('Sin asignar'),
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
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pendiente',
                        'confirmed' => 'Confirmada',
                        'completed' => 'Completada',
                        'cancelled' => 'Cancelada',
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
