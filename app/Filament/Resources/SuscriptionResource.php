<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuscriptionResource\Pages;
use App\Filament\Resources\SuscriptionResource\RelationManagers;
use App\Models\Pay;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;

class SuscriptionResource extends Resource
{
    protected static ?string $model = Pay::class;

    protected static ?string $modelLabel = 'suscripción';
    protected static ?string $pluralModelLabel = 'suscripciones';

    protected static ?string $navigationIcon = 'heroicon-o-wallet';
    protected static ?string $navigationLabel = 'Suscripciones';
    protected static ?string $navigationGroup = 'Asistencia y Test';

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
            ->columns([
                TextColumn::make('client.document')
                    ->searchable()
                    ->color('success')
                    ->copyable()
                    ->copyMessage('Copiado al portapapeles.')
                    ->copyMessageDuration(1500)
                    ->icon('heroicon-o-identification'),
                TextColumn::make('client.name')
                    ->label('Nombre del cliente')
                    ->searchable(),
                TextColumn::make('amount')
                    ->label('Costo')
                    ->money('COP'),
                TextColumn::make('start_date')
                    ->label('Fecha de inicio')
                    ->date('j/M/Y'),
                TextColumn::make('end_date')
                    ->label('Fecha de fin')
                    ->date('j/M/Y'),

            ])
            ->filters([
                Filter::make('start_date')
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
                                fn (Builder $query, $date) => $query->where('start_date', '>=', $date),
                            )
                            ->when(
                                $data['date_to'] ?? null,
                                fn (Builder $query, $date) => $query->where('start_date', '<=', $date),
                            );

                    }),

            ])
            ->actions([
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
            ])->paginated([10, 25, 50])
            ->defaultPaginationPageOption(25);
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
            'index' => Pages\ListSuscriptions::route('/'),
        ];
    }
}
