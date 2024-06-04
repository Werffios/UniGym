<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Models\Client;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
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

                          TextInput::make('weight')
                              ->label('Peso')
                              ->required()
                              ->hint('Medida en Kg')
                              ->placeholder('Ingrese la medida del pliegue en Kg')
                              ->numeric()
                              ->inputMode('decimal'),
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

    /**
     * @throws \Exception
     */
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('date')
            ->columns([
                TextColumn::make('date')
                    ->date('j/M/Y')
                    ->label('Fecha'),

                TextColumn::make('upperLimbs')
                    ->label('Miembros superiores'),

                TextColumn::make('lowerLimbs')
                    ->label('Miembros inferiores'),

                TextColumn::make('relationUpperLowerLimbs')
                    ->label('Relación miembros superiores e inferiores')
                    ->suffix(' %'),
            
                TextColumn::make('weight')
                ->label('Peso Kg'),

            ])
            ->defaultSort('id', 'desc')
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
                Tables\Actions\CreateAction::make()
                    ->createAnother(false)
                    ->label('Agregar test de fuerza'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->mutateRecordDataUsing(
                        function (array $data) {

                            $client = Client::find($data['client_id']);
                            if ($client == null) {
                                throw new \Exception('Cliente no encontrado');
                            }
                            $weight = $client->weight;
                            $gender = $client->gender;

                            if ($weight == null) {
                                Notification::make()
                                    ->title('Peso no definido')
                                    ->body('El peso del cliente no está definido, por favor, defínalo.')
                                    ->danger()
                                    ->send();

                                return $data;
                            }else{
                                $dataForce = [
                                    // upper limbs
                                    'benchPressMaxForce' => round($data['benchPress'] * 100 / (102.78 - (2.78 * $data['benchPressReps']))),
                                    'pulleyOpenHighMaxForce' => round($data['pulleyOpenHigh'] * 100 / (102.78 - (2.78 * $data['pulleyOpenHighReps']))),
                                    'barbellBicepsCurlMaxForce' => round($data['barbellBicepsCurl'] * 100 / (102.78 - (2.78 * $data['barbellBicepsCurlReps']))),

                                    // lower limbs
                                    'flexionLegsMaxForce' => round($data['legFlexion'] * 100 / (102.78 - (2.78 * $data['legFlexionReps']))),
                                    'legExtensionMaxForce' => round($data['legExtension'] * 100 / (102.78 - (2.78 * $data['legExtensionReps']))),
                                    'flexExtLegsMaxForce' => round($data['legFlexExt'] * 100 / (102.78 - (2.78 * $data['legFlexExtReps']))),
                                ];

                                $dataForce['benchPressForce/Peso'] = round($dataForce['benchPressMaxForce'] / $weight, 2);
                                $dataForce['pulleyOpenHighForce/Peso'] = round($dataForce['pulleyOpenHighMaxForce'] / $weight, 2);
                                $dataForce['barbellBicepsCurlForce/Peso'] = round($dataForce['barbellBicepsCurlMaxForce'] / $weight, 2);
                                $dataForce['flexionLegsForce/Peso'] = round($dataForce['flexionLegsMaxForce'] / $weight, 2);
                                $dataForce['legExtensionForce/Peso'] = round($dataForce['legExtensionMaxForce'] / $weight, 2);
                                $dataForce['flexExtLegsForce/Peso'] = round($dataForce['flexExtLegsMaxForce'] / $weight, 2);


                                $controlgenderPressForce = $gender == 'Masculino' ? 0 : -0.5;

                                if ($dataForce['benchPressForce/Peso'] >= 1.3 + $controlgenderPressForce) {
                                    $dataForce['benchPressForceClassification'] = 'Optimo';
                                } elseif ($dataForce['benchPressForce/Peso'] >= 1 + $controlgenderPressForce && $dataForce['benchPressForce/Peso'] < 1.3 + $controlgenderPressForce) {
                                    $dataForce['benchPressForceClassification'] = 'Mejoramiento';
                                } else {
                                    $dataForce['benchPressForceClassification'] = 'Bajo rendimiento';
                                }

                                $controlgenderPulleyForce = $gender == 'Masculino' ? 0 : -0.35;

                                if ($dataForce['pulleyOpenHighForce/Peso'] >= 1.1 + $controlgenderPulleyForce) {
                                    $dataForce['pulleyOpenHighForceClassification'] = 'Optimo';
                                } elseif ($dataForce['pulleyOpenHighForce/Peso'] >= 0.95 + $controlgenderPulleyForce && $dataForce['pulleyOpenHighForce/Peso'] < 1.1 + $controlgenderPulleyForce) {
                                    $dataForce['pulleyOpenHighForceClassification'] = 'Mejoramiento';
                                } else {
                                    $dataForce['pulleyOpenHighForceClassification'] = 'Bajo rendimiento';
                                }

                                $controlgenderBicepsForce = $gender == 'Masculino' ? 0 : -0.2;

                                if ($dataForce['barbellBicepsCurlForce/Peso'] >= 0.6 + $controlgenderBicepsForce) {
                                    $dataForce['barbellBicepsCurlForceClassification'] = 'Optimo';
                                } elseif ($dataForce['barbellBicepsCurlForce/Peso'] >= 0.45 + $controlgenderBicepsForce && $dataForce['barbellBicepsCurlForce/Peso'] < 0.6 + $controlgenderBicepsForce) {
                                    $dataForce['barbellBicepsCurlForceClassification'] = 'Mejoramiento';
                                } else {
                                    $dataForce['barbellBicepsCurlForceClassification'] = 'Bajo rendimiento';
                                }

                                $controlgenderLegsForce = $gender == 'Masculino' ? 0 : -0.3;

                                if ($dataForce['flexionLegsForce/Peso'] >= 2.6 + $controlgenderLegsForce) {
                                    $dataForce['flexionLegsForceClassification'] = 'Optimo';
                                } elseif ($dataForce['flexionLegsForce/Peso'] >= 2 + $controlgenderLegsForce && $dataForce['flexionLegsForce/Peso'] < 2.6 + $controlgenderLegsForce) {
                                    $dataForce['flexionLegsForceClassification'] = 'Mejoramiento';
                                } else {
                                    $dataForce['flexionLegsForceClassification'] = 'Bajo rendimiento';
                                }

                                $controlgenderExtensionForce = $gender == 'Masculino' ? 0 : -0.1;

                                if ($dataForce['legExtensionForce/Peso'] >= 0.7 + $controlgenderExtensionForce) {
                                    $dataForce['legExtensionForceClassification'] = 'Optimo';
                                } elseif ($dataForce['legExtensionForce/Peso'] >= 0.55 + $controlgenderExtensionForce && $dataForce['legExtensionForce/Peso'] < 0.7 + $controlgenderExtensionForce) {
                                    $dataForce['legExtensionForceClassification'] = 'Mejoramiento';
                                } else {
                                    $dataForce['legExtensionForceClassification'] = 'Bajo rendimiento';
                                }

                                $controlgenderFlexExtForce = $gender == 'Masculino' ? 0 : -0.1;

                                if ($dataForce['flexExtLegsForce/Peso'] >= 0.6 + $controlgenderFlexExtForce) {
                                    $dataForce['flexExtLegsForceClassification'] = 'Optimo';
                                } elseif ($dataForce['flexExtLegsForce/Peso'] >= 0.45 + $controlgenderFlexExtForce && $dataForce['flexExtLegsForce/Peso'] < 0.6 + $controlgenderFlexExtForce) {
                                    $dataForce['flexExtLegsForceClassification'] = 'Mejoramiento';
                                } else {
                                    $dataForce['flexExtLegsForceClassification'] = 'Bajo rendimiento';
                                }

                                $dataForce['benchPressForce75'] = round($dataForce['benchPressMaxForce'] * 0.75, 2);
                                $dataForce['pulleyOpenHighForce75'] = round($dataForce['pulleyOpenHighMaxForce'] * 0.75, 2);
                                $dataForce['barbellBicepsCurlForce75'] = round($dataForce['barbellBicepsCurlMaxForce'] * 0.75, 2);
                                $dataForce['flexionLegsForce75'] = round($dataForce['flexionLegsMaxForce'] * 0.75, 2);
                                $dataForce['legExtensionForce75'] = round($dataForce['legExtensionMaxForce'] * 0.75, 2);
                                $dataForce['flexExtLegsForce75'] = round($dataForce['flexExtLegsMaxForce'] * 0.75, 2);

                                $dataForce['benchPressForce70'] = round($dataForce['benchPressMaxForce'] * 0.70, 2);
                                $dataForce['pulleyOpenHighForce70'] = round($dataForce['pulleyOpenHighMaxForce'] * 0.70, 2);
                                $dataForce['barbellBicepsCurlForce70'] = round($dataForce['barbellBicepsCurlMaxForce'] * 0.70, 2);
                                $dataForce['flexionLegsForce70'] = round($dataForce['flexionLegsMaxForce'] * 0.70, 2);
                                $dataForce['legExtensionForce70'] = round($dataForce['legExtensionMaxForce'] * 0.70, 2);
                                $dataForce['flexExtLegsForce70'] = round($dataForce['flexExtLegsMaxForce'] * 0.70, 2);

                                $dataForce['benchPressForce65'] = round($dataForce['benchPressMaxForce'] * 0.65, 2);
                                $dataForce['pulleyOpenHighForce65'] = round($dataForce['pulleyOpenHighMaxForce'] * 0.65, 2);
                                $dataForce['barbellBicepsCurlForce65'] = round($dataForce['barbellBicepsCurlMaxForce'] * 0.65, 2);
                                $dataForce['flexionLegsForce65'] = round($dataForce['flexionLegsMaxForce'] * 0.65, 2);
                                $dataForce['legExtensionForce65'] = round($dataForce['legExtensionMaxForce'] * 0.65, 2);
                                $dataForce['flexExtLegsForce65'] = round($dataForce['flexExtLegsMaxForce'] * 0.65, 2);

                                $dataForce['benchPressForce60'] = round($dataForce['benchPressMaxForce'] * 0.60, 2);
                                $dataForce['pulleyOpenHighForce60'] = round($dataForce['pulleyOpenHighMaxForce'] * 0.60, 2);
                                $dataForce['barbellBicepsCurlForce60'] = round($dataForce['barbellBicepsCurlMaxForce'] * 0.60, 2);
                                $dataForce['flexionLegsForce60'] = round($dataForce['flexionLegsMaxForce'] * 0.60, 2);
                                $dataForce['legExtensionForce60'] = round($dataForce['legExtensionMaxForce'] * 0.60, 2);
                                $dataForce['flexExtLegsForce60'] = round($dataForce['flexExtLegsMaxForce'] * 0.60, 2);

                                return $dataForce;
                            }
                        }
                    )
                    ->form([
                        Fieldset::make('Press de banca plana')
                            ->schema([
                            TextInput::make('benchPressMaxForce')
                                ->label('Máxima'),
                            TextInput::make('benchPressForce75')
                                ->label('75%'),
                            TextInput::make('benchPressForce70')
                                ->label('70%'),
                            TextInput::make('benchPressForce65')
                                ->label('65%'),
                            TextInput::make('benchPressForce60')
                                ->label('60%'),
                            TextInput::make('benchPressForce/Peso')
                                ->label('Fuerza/Peso'),
                            TextInput::make('benchPressForceClassification')
                                ->label('Clasificación'),
                        ])
                            ->columns(7),

                        Fieldset::make('Polea alta abierta')
                            ->schema([
                            TextInput::make('pulleyOpenHighMaxForce')
                                ->label('Máxima'),
                            TextInput::make('pulleyOpenHighForce75')
                                ->label('75%'),
                            TextInput::make('pulleyOpenHighForce70')
                                ->label('70%'),
                            TextInput::make('pulleyOpenHighForce65')
                                ->label('65%'),
                            TextInput::make('pulleyOpenHighForce60')
                                ->label('60%'),
                            TextInput::make('pulleyOpenHighForce/Peso')
                                ->label('Fuerza/Peso'),
                            TextInput::make('pulleyOpenHighForceClassification')
                                ->label('Clasificación'),
                        ])->columns(7),

                        Fieldset::make('Curl de bíceps con barra')
                            ->schema([
                            TextInput::make('barbellBicepsCurlMaxForce')
                                ->label('Máxima'),
                            TextInput::make('barbellBicepsCurlForce75')
                                ->label('75%'),
                            TextInput::make('barbellBicepsCurlForce70')
                                ->label('70%'),
                            TextInput::make('barbellBicepsCurlForce65')
                                ->label('65%'),
                            TextInput::make('barbellBicepsCurlForce60')
                                ->label('60%'),
                            TextInput::make('barbellBicepsCurlForce/Peso')
                                ->label('Fuerza/Peso'),
                            TextInput::make('barbellBicepsCurlForceClassification')
                                ->label('Clasificación'),
                        ])->columns(7),

                        Fieldset::make('Flexión de piernas')
                            ->schema([
                            TextInput::make('flexionLegsMaxForce')
                                ->label('Máxima'),
                            TextInput::make('flexionLegsForce75')
                                ->label('75%'),
                            TextInput::make('flexionLegsForce70')
                                ->label('70%'),
                            TextInput::make('flexionLegsForce65')
                                ->label('65%'),
                            TextInput::make('flexionLegsForce60')
                                ->label('60%'),
                            TextInput::make('flexionLegsForce/Peso')
                                ->label('Fuerza/Peso'),
                            TextInput::make('flexionLegsForceClassification')
                                ->label('Clasificación'),
                        ])->columns(7),

                        Fieldset::make('Extensión de piernas')
                            ->schema([
                            TextInput::make('legExtensionMaxForce')
                                ->label('Máxima'),
                            TextInput::make('legExtensionForce75')
                                ->label('75%'),
                            TextInput::make('legExtensionForce70')
                                ->label('70%'),
                            TextInput::make('legExtensionForce65')
                                ->label('65%'),
                            TextInput::make('legExtensionForce60')
                                ->label('60%'),
                            TextInput::make('legExtensionForce/Peso')
                                ->label('Fuerza/Peso'),
                            TextInput::make('legExtensionForceClassification')
                                ->label('Clasificación'),
                        ])->columns(7),

                        Fieldset::make('Flex-ext de piernas')
                            ->schema([
                            TextInput::make('flexExtLegsMaxForce')
                                ->label('Máxima'),
                            TextInput::make('flexExtLegsForce75')
                                ->label('75%'),
                            TextInput::make('flexExtLegsForce70')
                                ->label('70%'),
                            TextInput::make('flexExtLegsForce65')
                                ->label('65%'),
                            TextInput::make('flexExtLegsForce60')
                                ->label('60%'),
                            TextInput::make('flexExtLegsForce/Peso')
                                ->label('Fuerza/Peso'),
                            TextInput::make('flexExtLegsForceClassification')
                                ->label('Clasificación'),
                        ])->columns(7),

                    ])
                    ->modalWidth('7xl')
                    //->modalHidden()
                    ->iconButton()
                    ->icon('heroicon-o-window')
                    ->color('primary')
                    ->tooltip('Ver detalles del test de fuerza')
                    ->label('')
                ,
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Eliminar test de fuerza')
                    ->label(''),
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
