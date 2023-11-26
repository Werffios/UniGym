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


    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('bicepCircumference')
                    ->label('Circunferencia del bicep')
                    ->required()
                    ->numeric(),
                TextInput::make('tricepCircumference')
                    ->label('Circunferencia del tricep')
                    ->required()
                    ->numeric(),
                TextInput::make('carpusPerimeter')
                    ->label('Perímetro del carpo')
                    ->required()
                    ->numeric(),
                TextInput::make('subscapular')
                    ->label('Subescapular')
                    ->required()
                    ->numeric(),
                TextInput::make('suprailiac')
                    ->label('Suprailíaco')
                    ->required()
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

                TextColumn::make('healthyWeight')
                    ->label('Peso saludable'),

                TextColumn::make('IMC')
                    ->label('IMC'),

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
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
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
