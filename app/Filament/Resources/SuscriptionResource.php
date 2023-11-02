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

class SuscriptionResource extends Resource
{
    protected static ?string $model = Pay::class;

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
                    ->searchable(),
                TextColumn::make('end_date')
                    ->label('Fecha de fin')
                    ->searchable(),

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
            'index' => Pages\ListSuscriptions::route('/'),
            'create' => Pages\CreateSuscription::route('/create'),
            'edit' => Pages\EditSuscription::route('/{record}/edit'),
        ];
    }
}
