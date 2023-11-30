<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use Filament\Forms;
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

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('date')
                    ->required()
                    ->maxLength(255),
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
                    ->label('Pulso en reposo'),

                TextColumn::make('effortPulse')
                    ->label('Pulso en esfuerzo'),

                TextColumn::make('recoveryPulse')
                    ->label('Pulso en recuperación'),

                TextColumn::make('VO2max')
                    ->label('VO2max'),

                TextColumn::make('VO2maxEvaluation')
                    ->label('Valoración VO2max'),

                TextColumn::make('FCmax')
                    ->label('FCmax'),

                TextColumn::make('FCReposo')
                    ->label('FCReposo'),

                TextColumn::make('FCReserva')
                    ->label('FCReserva'),



            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
