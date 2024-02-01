<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use Faker\Core\File;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\TextInput;

class TestAnthropometryRelationManager extends RelationManager
{
    protected static string $relationship = 'testAnthropometry';

    protected static ?string $title = 'Test de antropometría';


    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('clients.height')->label('Estatura del usuario')
                    ->numeric()
                    ->minLength(2)
                    ->maxLength(3)
                    ->placeholder('Ingrese la altura del usuario en CM')
                    ->helperText('Ejemplo: 170'),
//                    ->hidden(empty($this->record->height)),

                TextInput::make('bicepFold')
                    ->label('Biceps')
                    ->required()
                    ->hint('Medida en cm')
                    ->placeholder('Ingrese la medida del pliegue en CM')
                    ->numeric(),

                TextInput::make('tricepFold')
                    ->label('Triceps')
                    ->required()
                    ->hint('Medida en cm')
                    ->placeholder('Ingrese la medida del pliegue en CM')
                    ->numeric(),

                TextInput::make('subscapular')
                    ->label('Subescapular')
                    ->required()
                    ->hint('Medida en mm')
                    ->placeholder('Ingrese la medida del pliegue en CM')
                    ->numeric(),

                TextInput::make('suprailiac')
                    ->label('Suprailíaco')
                    ->required()
                    ->hint('Medida en mm')
                    ->placeholder('Ingrese la medida del pliegue en CM')
                    ->numeric(),
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

                TextColumn::make('fatPercentage')
                    ->label('Grasa')
                    ->suffix(' %'),

                TextColumn::make('fatPercentageEvaluation')
                    ->label('Evaluación grasa'),

                TextColumn::make('healthyWeight')
                    ->label('Peso saludable')
                    ->suffix(' kg'),

                TextColumn::make('IMC')
                    ->label('IMC'),

                TextColumn::make('IMCEvaluation')
                    ->label('Evaluación IMC'),

            ])->defaultSort('id', 'desc')
            ->filters([
                Filter::make('date')
                    ->label('Filtrar fechas')
                    ->form([
                        DatePicker::make('date_from')
                            ->native(False)
                            ->closeOnDateSelection()
                            ->prefix('Desde')
                            ->label('Fecha de inicio'),
                        DatePicker::make('date_to')
                            ->native(False)
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
                    ->label('Nuevo test de antropometría')

            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Eliminar test de antropometría')
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
