<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeeResource\Pages;
use App\Filament\Resources\FeeResource\RelationManagers;
use App\Models\type_client;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
class FeeResource extends Resource
{
    protected static ?string $model = type_client::class;


    protected static ?string $modelLabel = 'tarifa';

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Mantenimiento';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Nombre de la tarifa')
                    ->required()
                    ->minLength(2)
                    ->maxLength(100)
                    ->placeholder('Ingrese el nombre de la tarifa')
                    ->helperText('Escribe el nombre de la tarifa.')
                    ->autocomplete(false)
                    ->hint('El nombre debe ser único.'),
                TextInput::make('fee')->label('Tarifa')
                    ->required()
                    ->minLength(2)
                    ->maxLength(255)
                    ->placeholder('Ingrese la tarifa')
                    ->helperText('Escribe la tarifa.')
                    ->autocomplete(false)
                    ->hint('La tarifa debe ser única.'),
                TextInput::make('months')->label('Meses')
                    ->required()
                    ->maxLength(1)
                    ->placeholder('Ingrese los meses')
                    ->helperText('Escribe los meses.')
                    ->autocomplete(false)
                    ->hint('Los meses deben ser únicos.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('fee')
                    // dollars
                    ->money('COP')
                    ->searchable(),
                TextColumn::make('months'),
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
            'index' => Pages\ListFees::route('/'),
            'create' => Pages\CreateFee::route('/create'),
            'edit' => Pages\EditFee::route('/{record}/edit'),
        ];
    }
}
