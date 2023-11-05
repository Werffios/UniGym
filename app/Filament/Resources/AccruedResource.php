<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccruedResource\Pages;
use App\Filament\Resources\AccruedResource\RelationManagers;
use App\Models\type_client;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Summarizers\Count as CountSummarizer;
use PHPUnit\Framework\Constraint\Count;

class AccruedResource extends Resource
{
    protected static ?string $model = type_client::class;

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
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('fee')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('months')
                    ->searchable(),
                TextColumn::make('clients.attendances_count')
                    ->label('Asistencias')
                    ->summarize([
                        CountSummarizer::make()
                        ->label('Total')
                    ]),
                TextColumn::make('subtotal')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'edit' => Pages\EditAccrued::route('/{record}/edit'),
        ];
    }
}
