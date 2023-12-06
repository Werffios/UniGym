<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use Filament\Forms;
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
                    ->label('Valoración VO2max'),

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
                    ->createAnother(false)
                    ->label('Nuevo test de forestry'),
            ])
            ->actions([
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
