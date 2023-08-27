<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\Widgets;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Infolists;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('document')->label('Documento del usuario')
                    ->numeric()
                    ->required()
                    ->minLength(2)
                    ->maxLength(10)
                    ->placeholder('Ingrese el documento del cliente')
                    ->helperText('Escribe el documento del cliente.')
                    ->hint('El documento debe ser único.'),
                TextInput::make('name')->label('Nombre del usuario')
                    ->required()
                    ->minLength(3)
                    ->maxLength(50)
                    ->placeholder('Ingrese el nombre del cliente')
                    ->helperText('Escribe el nombre del cliente.')
                    ->hint('El nombre debe ser único.'),
                TextInput::make('surname')->label('Apellido del usuario')
                    ->required()
                    ->minLength(3)
                    ->maxLength(50)
                    ->placeholder('Ingrese el apellido del cliente')
                    ->helperText('Escribe el apellido del cliente.')
                    ->hint('El apellido debe ser único.'),
                DatePicker::make('birth_date')->label('Fecha de nacimiento del usuario')
                    ->required()
                    ->placeholder('Ingrese la fecha de nacimiento del cliente')
                    ->helperText('Escribe la fecha de nacimiento del cliente.')
                    ->hint('La fecha de nacimiento debe ser única.'),
                TextInput::make('height')->label('Altura del usuario')
                    ->numeric()
                    ->required()
                    ->minLength(2)
                    ->maxLength(3)
                    ->placeholder('Ingrese la altura del cliente en CM')
                    ->helperText('Ejemplo: 170'),
                TextInput::make('weight')->label('Peso del usuario')
                    ->numeric()
                    ->required()
                    ->minLength(2)
                    ->maxLength(4)
                    ->placeholder('Ingrese el peso del cliente en KG')
                    ->helperText('Ejemplo: 70KG'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('document')->label('Número de documento')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copiado al portapapeles.')
                    ->copyMessageDuration(1500),
                TextColumn::make('name')->label('Nombre')
                    ->searchable(),
                TextColumn::make('surname')->label('Apellido')
                    ->searchable(),
                TextColumn::make('birth_date')->label('Fecha de nacimiento')
                    ->searchable()
                    ->date('j/M/Y'),
                TextColumn::make('attendances_count')->label('Asistencias')
                    ->sortable()
                    ->counts('attendances'),

            ])->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\AttendancesRelationManager::class,
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist -> schema([
            Infolists\Components\TextEntry::make('document')
                ->label('Documento')
                ->badge()
                ->color('success')
                ->size('lg')
                ->copyable()
                ->copyMessage('Copiado al portapapeles.')
                ->copyMessageDuration(1500),
            Infolists\Components\TextEntry::make('birth_date')
                ->label('Fecha de nacimiento')
                ->date('j/M/Y'),
            Infolists\Components\TextEntry::make('name')
                ->label('Nombre'),
            Infolists\Components\TextEntry::make('surname')
                ->label('Apellido'),
            Infolists\Components\TextEntry::make('birth_date')
                ->label('Edad')
                ->since(),
            Infolists\Components\TextEntry::make('height')
                ->label('Altura'),
            Infolists\Components\TextEntry::make('weight')
                ->label('Peso'),

        ]);





            //->color(fn (string $state): string => match ($state) {
            //        'active' => 'danger',
            //        'desactive' => 'success',
            //    })
    }

    public static function getWidgets(): array
    {
        return [
            Widgets\AttendanceOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageClients::route('/'),
            'view' => Pages\ViewClient::route('/{record}/view'),
        ];
    }
}
