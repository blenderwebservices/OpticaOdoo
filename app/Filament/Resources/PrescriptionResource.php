<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrescriptionResource\Pages;
use App\Models\Prescription;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PrescriptionResource extends Resource
{
    protected static ?string $model = Prescription::class;

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    protected static ?string $navigationLabel = 'Recetas Ópticas';

    protected static ?string $pluralModelLabel = 'Recetas Ópticas / Graduaciones';

    protected static ?string $navigationGroup = 'Clínica & Salud Visual';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Paciente')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Cliente Registrado')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('patient_name')
                            ->label('Nombre del Paciente')
                            ->required(),
                        Forms\Components\DatePicker::make('issue_date')
                            ->label('Fecha de Expedición')
                            ->default(now()),
                        Forms\Components\TextInput::make('pd')
                            ->label('Distancia Pupilar (DP en mm)')
                            ->placeholder('Ej. 62 mm'),
                    ])->columns(2),

                Forms\Components\Section::make('Graduación Ojo Derecho (OD - Oculus Dexter)')
                    ->schema([
                        Forms\Components\TextInput::make('sph_od')->label('Esfera (SPH OD)')->placeholder('-2.50'),
                        Forms\Components\TextInput::make('cyl_od')->label('Cilindro (CYL OD)')->placeholder('-0.75'),
                        Forms\Components\TextInput::make('axis_od')->label('Eje (AXIS OD)')->placeholder('180°'),
                        Forms\Components\TextInput::make('add_od')->label('Adición (ADD OD)')->placeholder('+1.50'),
                    ])->columns(4),

                Forms\Components\Section::make('Graduación Ojo Izquierdo (OS - Oculus Sinister)')
                    ->schema([
                        Forms\Components\TextInput::make('sph_os')->label('Esfera (SPH OS)')->placeholder('-2.25'),
                        Forms\Components\TextInput::make('cyl_os')->label('Cilindro (CYL OS)')->placeholder('-1.00'),
                        Forms\Components\TextInput::make('axis_os')->label('Eje (AXIS OS)')->placeholder('175°'),
                        Forms\Components\TextInput::make('add_os')->label('Adición (ADD OS)')->placeholder('+1.50'),
                    ])->columns(4),

                Forms\Components\Section::make('Notas Oftalmológicas / Optometría')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->label('Observaciones del Diagnóstico')
                            ->columnSpanFull(),
                    ]),
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
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario Vinculado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sph_od')
                    ->label('SPH OD')
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('sph_os')
                    ->label('SPH OS')
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('pd')
                    ->label('DP (mm)')
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('issue_date')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListPrescriptions::route('/'),
            'create' => Pages\CreatePrescription::route('/create'),
            'edit' => Pages\EditPrescription::route('/{record}/edit'),
        ];
    }
}
