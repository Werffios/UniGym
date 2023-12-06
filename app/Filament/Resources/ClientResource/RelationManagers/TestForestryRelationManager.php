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
                            if ($data['VO2maxEvaluation'] == 'Excelente' or $data['VO2maxEvaluation'] == 'Muy bien') {
                                $dataForestry =
                                    [
                                        'stage' => '

De mejoramiento
De mejoramiento
De mejoramiento
De mejoramiento
De mejoramiento
De mejoramiento
De mejoramiento
De mantenimiento',
                                        'week' => '

1-3
4-6
7-9
10-12
13-15
16-18
19-21
>21',
                                        'VO2Range' => '

40-50
50
60
60-70
60-70
40-50
50
60',
                                        'minutes' => '

15-20
15-20
20-25
25-30
30-35
30-35
30-35
30-45',
                                    ];
                            }else{
                                $dataForestry =
                                    [
                                        'stage' => 'Inicial
Inicial
Inicial
Inicial
Inicial
De mejoramiento
De mejoramiento
De mejoramiento
De mejoramiento
De mejoramiento
De mejoramiento
De mantenimiento',
                                        'week' => '1-3
4-6
7-9
10-12
13-15
16-18
19-21
22-24
25-27
28-30
31-33
>33',
                                        'VO2Range' => '40-50
50
60
60-70
60-70
40-50
50
60
60-70
60-70
60-70
70-85',
                                        'minutes' => '15-20
15-20
20-25
25-30
30-35
30-35
30-35
30-35
30-35
30-35
30-35
30-45',
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
                                    ->label('Rango de VO2'),
                                Textarea::make('minutes')
                                    ->rows(12)
                                    ->extraAttributes(['style' => 'resize: none;'])
                                    ->label('Minutos'),
                            ])
                            ->columns(4),
                    ])
                    ->iconButton()
                    ->icon('heroicon-o-window')
                    ->color('primary')
                    ->tooltip('Ver test de forestry')
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
