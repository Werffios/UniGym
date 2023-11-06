<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccruedResource\Pages;
use App\Filament\Resources\AccruedResource\RelationManagers;
use App\Models\Pay;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Sum;

class AccruedResource extends Resource
{
    protected static ?string $model = Pay::class;

    protected static ?string $modelLabel = 'recaudo';

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Recaudos';

    protected static ?string $navigationGroup = 'Finanzas';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                'client.typeClient.name',
                'client.degree.name',
                'client.degree.faculty.name',
            ])
            ->defaultGroup('client.typeClient.name')
            ->columns([
                TextColumn::make('client.name')
                    ->label('Nombre')
                    ->searchable(),
                TextColumn::make('client.surname')
                    ->label('Apellido')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->label('Fecha de inicio')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('Fecha de fin')
                    ->sortable(),
                TextColumn::make('amount')
                    ->searchable()
                    ->money('COP')
                    ->summarize(Sum::make()),

            ])
            ->filters([
                Filter::make('start_date')
                    ->label('Filtrar fechas')
                    ->form([
                        DatePicker::make('date_from')
                            ->label('Fecha de inicio'),
                        DatePicker::make('date_to')
                            ->label('Fecha de fin'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when(
                                $data['date_from'] ?? null,
                                fn (Builder $query, $date) => $query->where('start_date', '>=', $date),
                            )
                            ->when(
                                $data['date_to'] ?? null,
                                fn (Builder $query, $date) => $query->where('start_date', '<=', $date),
                            );

                    }),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccrueds::route('/'),
            'create' => Pages\CreateAccrued::route('/create'),
            // 'edit' => Pages\EditAccrued::route('/{record}/edit'),
        ];
    }
}
