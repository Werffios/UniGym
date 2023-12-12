<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestForestryRelationManager extends RelationManager
{
    protected static string $relationship = 'testForestry';

    protected static ?string $title = 'Test de Forestry';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('restingPulse')
                    ->numeric()
                    ->required()
                    ->hint('Ingrese el valor en pulsaciones por minuto')
                    ->label('Pulso en reposo'),
                TextInput::make('effortPulse')
                    ->numeric()
                    ->required()
                    ->hint('Ingrese el valor en pulsaciones por minuto')
                    ->label('Pulso en esfuerzo'),
                TextInput::make('recoveryPulse')
                    ->numeric()
                    ->required()
                    ->hint('Ingrese el valor en pulsaciones por minuto')
                    ->label('Pulso en recuperación'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('date')
            ->columns([
                TextColumn::make('date')
                    ->date('j/M/Y')
                    ->label('Fecha'),

                TextColumn::make('restingPulse')
                    ->label('Pulso en reposo')
                    ->suffix(' ppm'),

                TextColumn::make('effortPulse')
                    ->label('Pulso en esfuerzo')
                    ->suffix(' ppm'),

                TextColumn::make('recoveryPulse')
                    ->label('Pulso en recuperación')
                    ->suffix(' ppm'),

                TextColumn::make('VO2max')
                    ->label('VO2max')
                    ->suffix(' ml/kg/min'),

                TextColumn::make('VO2maxEvaluation')
                    ->label('Valoración VO2'),

                TextColumn::make('FCmax')
                    ->label('FCmax')
                    ->suffix(' ppm'),

                TextColumn::make('FCReposo')
                    ->label('FCReposo')
                    ->suffix(' ppm'),

                TextColumn::make('FCReserva')
                    ->label('FCReserva')
                    ->suffix(' ppm'),

            ])->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Crear test de forestry'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->mutateRecordDataUsing(
                        function (array $data) {
                            $FCReposo = $data['FCReposo'];
                            $FCReserva = $data['FCReserva'];
                            if ($data['VO2maxEvaluation'] == 'Excelente' or $data['VO2maxEvaluation'] == 'Muy bien') {
                                $dataForestry =
                                    [
                                        'stage' => '

Mejoramiento
Mejoramiento
Mejoramiento
Mejoramiento
Mejoramiento
Mejoramiento
Mejoramiento
MaMntenimiento',
                                        'week' => '

 1 - 3
 4 - 6
 7 - 9
10 - 12
13 - 15
16 - 18
19 - 21
>21',
                                        'VO2Range' => '

60 - 70
70 - 80
70 - 80
70 - 80
70 - 80
70 - 80
70 - 80
70 - 85',

                                        'minutes' => '

15 - 20
15 - 20
20 - 25
25 - 30
30 - 35
30 - 35
30 - 35
30   - 35',
                                        // Convierto un valor a string para que no se muestre el guión como rango
                                        'FCMin - FCMax' => "\n\n" .strval((0.6 * $FCReserva) + $FCReposo) . ' -  '  . strval((0.7 * $FCReserva) + $FCReposo) . "\n" .
                                        strval((0.7 * $FCReserva) + $FCReposo) . ' - ' . strval((0.8 * $FCReserva) + $FCReposo) . "\n" .
                                        strval((0.7 * $FCReserva) + $FCReposo) . ' - ' . strval((0.8 * $FCReserva) + $FCReposo) . "\n" .
                                        strval((0.7 * $FCReserva) + $FCReposo) . ' - ' . strval((0.8 * $FCReserva) + $FCReposo) . "\n" .
                                        strval((0.7 * $FCReserva) + $FCReposo) . ' - ' . strval((0.8 * $FCReserva) + $FCReposo) . "\n" .
                                        strval((0.7 * $FCReserva) + $FCReposo) . ' - ' . strval((0.8 * $FCReserva) + $FCReposo) . "\n" .
                                        strval((0.7 * $FCReserva) + $FCReposo) . ' - ' . strval((0.8 * $FCReserva) + $FCReposo) . "\n" .
                                        strval((0.7 * $FCReserva) + $FCReposo) . ' - ' . strval((0.85 * $FCReserva) + $FCReposo),


                                    ];
                            }else{
                                $dataForestry =
                                    [
                                        'stage' => 'Inicial
Inicial
Inicial
Inicial
Inicial
Mejoramiento
Mejoramiento
Mejoramiento
Mejoramiento
Mejoramiento
Mejoramiento
Mantenimiento',
                                        'week' => ' 1 - 3
 4 - 6
 7 - 9
10 - 12
13 - 15
16 - 18
19 - 21
22 - 24
25 - 27
28 - 30
31 - 33
>33',
                                        'VO2Range' => '40 - 50
50
60
60 - 70
70 - 80
70 - 80
70 - 80
70 - 80
70 - 80
70 - 80
70 - 80
70 - 85',
                                        'minutes' => '15 - 20
15 - 20
20 - 25
25 - 30
30 - 35
30 - 35
30 - 35
30 - 35
30 - 35
30 - 35
30 - 35
30 - 35',
                                        'FCMin - FCMax' => strval((0.4 * $FCReserva) + $FCReposo) . ' -  '  . strval((0.5 * $FCReserva) + $FCReposo) . "\n" .
                                        strval((0.5 * $FCReserva) + $FCReposo) . "\n" .
                                        strval((0.6 * $FCReserva) + $FCReposo) . "\n" .
                                        strval((0.6 * $FCReserva) + $FCReposo) . ' - ' . strval((0.7 * $FCReserva) + $FCReposo) . "\n" .
                                        strval((0.6 * $FCReserva) + $FCReposo) . ' - ' . strval((0.7 * $FCReserva) + $FCReposo) . "\n" .
                                        strval((0.7 * $FCReserva) + $FCReposo) . ' - ' . strval((0.8 * $FCReserva) + $FCReposo) . "\n" .
                                        strval((0.7 * $FCReserva) + $FCReposo) . ' - ' . strval((0.8 * $FCReserva) + $FCReposo) . "\n" .
                                        strval((0.7 * $FCReserva) + $FCReposo) . ' - ' . strval((0.8 * $FCReserva) + $FCReposo) . "\n" .
                                        strval((0.7 * $FCReserva) + $FCReposo) . ' - ' . strval((0.8 * $FCReserva) + $FCReposo) . "\n" .
                                        strval((0.7 * $FCReserva) + $FCReposo) . ' - ' . strval((0.8 * $FCReserva) + $FCReposo) . "\n" .
                                        strval((0.7 * $FCReserva) + $FCReposo) . ' - ' . strval((0.8 * $FCReserva) + $FCReposo) . "\n" .
                                        strval((0.7 * $FCReserva) + $FCReposo) . ' - ' . strval((0.85 * $FCReserva) + $FCReposo) ,

                                    ];
                            }
                            return $dataForestry;
                        }
                    )
                    ->form([
                        Fieldset::make('Datos del test de forestry')
                            ->schema([
                                Textarea::make('stage')
                                    ->rows(12)
                                    ->extraAttributes(['style' => 'resize: none;'])
                                    ->label('Etapa'),
                                Textarea::make('week')
                                    ->rows(12)
                                    ->extraAttributes(['style' => 'resize: none;'])
                                    ->label('Semana'),
                                Textarea::make('VO2Range')
                                    ->rows(12)
                                    ->extraAttributes(['style' => 'resize: none;'])
                                    ->label('%VO2res. y %RFC'),
                                Textarea::make('minutes')
                                    ->rows(12)
                                    ->extraAttributes(['style' => 'resize: none;'])
                                    ->label('Minutos'),
                                Textarea::make('FCMin - FCMax')
                                    ->rows(12)
                                    ->extraAttributes(['style' => 'resize: none;'])
                                    ->label('FCMin - FCMax'),
                            ])
                            ->columns(5),
                    ])
                    ->iconButton()
                    ->icon('heroicon-o-window')
                    ->color('primary')
                    ->tooltip('Ver prescripción de entrenamiento')
                    ->label(''),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Eliminar test de forestry')
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
