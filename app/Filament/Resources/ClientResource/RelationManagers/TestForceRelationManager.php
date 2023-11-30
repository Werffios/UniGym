<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard;

class TestForceRelationManager extends RelationManager
{
    protected static string $relationship = 'testForce';

    protected static ?string $title = 'Test de fuerza';


    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('TrenSuperior')
                        ->description('Ejercicios de tren superior')
                        ->schema([
                            TextInput::make('benchPress')
                                ->numeric()
                                ->required()
                                ->hint('Ingrese el valor en Kg')
                                ->label('Press de banca plana'),
                            TextInput::make('benchPressReps')
                                ->numeric()
                                ->required()
                                ->hint('Ingrese el valor en repeticiones')
                                ->label('Repeticiones'),
                            TextInput::make('pulleyOpenHigh')
                                ->numeric()
                                ->required()
                                ->hint('Ingrese el valor en Kg')
                                ->label('Polea alta abierta'),
                            TextInput::make('pulleyOpenHighReps')
                                ->numeric()
                                ->required()
                                ->hint('Ingrese el valor en repeticiones')
                                ->label('Repeticiones'),
                            TextInput::make('barbellBicepsCurl')
                                ->numeric()
                                ->required()
                                ->hint('Ingrese el valor en Kg')
                                ->label('Curl de bíceps con barra'),
                            TextInput::make('barbellBicepsCurlReps')
                                ->numeric()
                                ->required()
                                ->hint('Ingrese el valor en repeticiones')
                                ->label('Repeticiones'),
                        ]),
                    Wizard\Step::make('Tren Inferior')
                        ->description('Ejercicios de tren inferior')
                        ->schema([
                            TextInput::make('legFlexion')
                                ->numeric()
                                ->required()
                                ->hint('Ingrese el valor en Kg')
                                ->label('Flexión de piernas'),
                            TextInput::make('legFlexionReps')
                                ->numeric()
                                ->required()
                                ->hint('Ingrese el valor en repeticiones')
                                ->label('Repeticiones'),
                            TextInput::make('legExtension')
                                ->numeric()
                                ->required()
                                ->hint('Ingrese el valor en Kg')
                                ->label('Extensión de piernas'),
                            TextInput::make('legExtensionReps')
                                ->numeric()
                                ->required()
                                ->hint('Ingrese el valor en repeticiones')
                                ->label('Repeticiones'),
                            TextInput::make('legFlexExt')
                                ->numeric()
                                ->required()
                                ->hint('Ingrese el valor en Kg')
                                ->label('Flex-ext de piernas'),
                            TextInput::make('legFlexExtReps')
                                ->numeric()
                                ->required()
                                ->hint('Ingrese el valor en repeticiones')
                                ->label('Repeticiones'),
                        ]),
                ])
                ->columns(2),
            ])
            ->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('testForce')
            ->columns([
                TextColumn::make('date')
                    ->date('j/M/Y')
                    ->label('Fecha'),

                TextColumn::make('upperLimbs')
                    ->label('Miembros superiores'),

                TextColumn::make('lowerLimbs')
                    ->label('Miembros inferiores'),

                TextColumn::make('relationUpperLowerLimbs')
                    ->label('Relación miembros superiores e inferiores (%)'),
            ])->defaultSort('id', 'desc')
            ->filters([
                Filter::make('date')
                    ->label('Filtrar fechas')
                    ->form([
                        DatePicker::make('date_from')
                            ->native(false)
                            ->closeOnDateSelection()
                            ->prefix('Desde')
                            ->label('Fecha de inicio'),
                        DatePicker::make('date_to')
                            ->native(false)
                            ->closeOnDateSelection()
                            ->prefix('Hasta')
                            ->label('Fecha de fin'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when(
                                $data['date_from'] ?? null,
                                fn (Builder $query, $date) => $query->where('date', '>=', $date),
                            )
                            ->when(
                                $data['date_to'] ?? null,
                                fn (Builder $query, $date) => $query->where('date', '<=', $date),
                            );
                    }),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
