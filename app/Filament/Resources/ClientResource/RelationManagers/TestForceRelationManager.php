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


    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form


            ->schema([
                Wizard::make([
                    Wizard\Step::make('Limbs')
                        ->schema([
                            TextInput::make('upperLimbs')
                                ->numeric()
                                ->required()
                                ->hint('Ingrese el valor en Kg')
                                ->label('Miembros superiores'),
                            TextInput::make('lowerLimbs')
                                ->numeric()
                                ->required()
                                ->hint('Ingrese el valor en Kg')
                                ->label('Miembros inferiores'),
                        ])
                    ->label('Miembros')
                    ->columnSpanFull(),
                    Wizard\Step::make('Relation')
                        ->schema([
                            TextInput::make('relationUpperLowerLimbs')
                                ->numeric()
                                ->required()
                                ->hint('Ingrese el valor en Kg')
                                ->label('Relación miembros superiores e inferiores (%)'),
                        ])
                    ->label('Relación')
                    ->columnSpanFull(),
                    Wizard\Step::make('Date')
                        ->schema([
                            DatePicker::make('date')
                                ->required()
                                ->native(false)
                                ->closeOnDateSelection()
                                ->hint('Ingrese la fecha')
                                ->label('Fecha'),
                        ])
                    ->label('Fecha')
                    ->columnSpanFull(),
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
