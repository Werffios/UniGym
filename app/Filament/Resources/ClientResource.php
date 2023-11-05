<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\Widgets;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use App\Models\type_client;
use App\Models\type_document;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Clientes';

    protected static ?string $navigationGroup = 'Asistencia y Test';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('document')->label('Documento del cliente')
                    ->unique(Client::class, 'document')
                    ->numeric()
                    ->minLength(2)
                    ->maxLength(12)
                    ->placeholder('Ingrese el documento del cliente')
                    ->helperText('Escribe el documento del cliente.')
                    ->hint('El documento debe ser único.'),
                Select::make('type_document_id')->label('Tipo de documento')
                    ->placeholder('Seleccione el tipo de documento')
                    ->options(
                        type_document::all()->pluck('name', 'id')
                    )
                    ->required()
                    ->searchable()
                    ->helperText('Seleccione el tipo de documento.'),
                TextInput::make('name')->label('Nombre del cliente')
                    ->required()
                    ->minLength(3)
                    ->maxLength(50)
                    ->placeholder('Ingrese el nombre del cliente')
                    ->helperText('Escribe el nombre del cliente.'),
                TextInput::make('surname')->label('Apellido del cliente')
                    ->required()
                    ->minLength(3)
                    ->maxLength(50)
                    ->placeholder('Ingrese el apellido del cliente')
                    ->helperText('Escribe el apellido del cliente.'),
                TextInput::make('height')->label('Altura del cliente')
                    ->numeric()
                    ->required()
                    ->minLength(2)
                    ->maxLength(3)
                    ->placeholder('Ingrese la altura del cliente en CM')
                    ->helperText('Ejemplo: 170'),
                TextInput::make('weight')->label('Peso del cliente')
                    ->numeric()
                    ->required()
                    ->minLength(2)
                    ->maxLength(4)
                    ->placeholder('Ingrese el peso del cliente en KG')
                    ->helperText('Ejemplo: 70'),

                Select::make('gender')->label('Género del cliente')
                    ->options([
                        'Masculino' => 'Masculino',
                        'Femenino' => 'Femenino',
                    ])
                    ->required()
                    ->placeholder('No ha seleccionado el género del cliente')
                    ->helperText('Seleccione el género del cliente.'),
                Select::make('type_client_id')->label('Tipo de cliente')
                    ->placeholder('Seleccione el tipo de cliente')
                    ->options(
                        type_client::all()->pluck('name', 'id')
                    )
                    ->required()
                    ->searchable()
                    ->helperText('Seleccione el tipo de cliente.'),


                DatePicker::make('birth_date')->label('Fecha de nacimiento del cliente')
                    ->required()
                    ->placeholder('Ingrese la fecha de nacimiento del cliente')
                    ->helperText('Escribe la fecha de nacimiento del cliente.'),

            ]);
    }

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('document')
                    ->label('Número de documento')
                    ->searchable()
                    ->color('success')
                    ->copyable()
                    ->copyMessage('Copiado al portapapeles.')
                    ->copyMessageDuration(1500)
                    ->icon('heroicon-o-identification'),
                IconColumn::make('active')
                    ->label('Estado')
                    ->boolean(),
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                TextColumn::make('surname')
                    ->label('Apellido')
                    ->searchable(),
                TextColumn::make('birth_date')
                    ->label('Fecha de nacimiento')
                    ->searchable()
                    ->date('j/M/Y'),
                TextColumn::make('attendances_count')
                    ->label('Asistencias')
                    ->sortable()
                    ->counts('attendances'),

            ])->defaultSort('id', 'desc')

            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil')
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->filters([
                SelectFilter::make('type_client_id')
                    ->label('Tipo de cliente')
                    ->multiple()
                    ->options(
                        type_client::all()->pluck('name', 'id')
                    )
                    ->searchable()
                    ->default(null),
                SelectFilter::make('type_document_id')
                    ->label('Tipo de documento')
                    ->multiple()
                    ->options(
                        type_document::all()->pluck('name', 'id')
                    )
                    ->searchable()
                    ->default(null),
                TernaryFilter::make('active')
                    ->label('Suscripción')
                    ->placeholder('Todos los clientes')
                    ->trueLabel('Clientes con suscripción activa')
                    ->falseLabel('Clientes con suscripción inactiva'),
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
        return $infolist
            -> schema([

            TextEntry::make('document')
                ->label('Documento')
                ->badge()
                ->color('success')
                ->copyable()
                ->copyMessage('Copiado al portapapeles.')
                ->copyMessageDuration(1500)
                ->icon('heroicon-o-identification'),

            IconEntry::make('active')
                ->label('Estado')
                ->boolean(),

            TextEntry::make('name')
                ->label('Nombre')
                ->icon('heroicon-o-user'),
            TextEntry::make('surname')
                ->label('Apellido')
                ->icon('heroicon-o-user'),
            TextEntry::make('birth_date')
                ->label('Edad')
                ->icon('heroicon-o-cake')
                ->since(),
            TextEntry::make('gender')
                ->label('Género')
                ->icon('heroicon-o-user-group'),

            TextEntry::make('height')
                ->label('Altura')
                ->icon('heroicon-o-arrows-up-down'),
            TextEntry::make('weight')
                ->label('Peso')
                ->icon('heroicon-o-scale'),


            TextEntry::make('birth_date')
                ->label('Fecha de nacimiento')
                ->icon('heroicon-o-calendar')
                ->date('j/M/Y'),


            TextEntry::make('typeClient.name')
                ->icon('heroicon-o-user-group'),

            TextEntry::make('typeDocument.name')
                ->icon('heroicon-o-identification'),


        ]);

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
