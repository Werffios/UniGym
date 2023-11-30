<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\Widgets;
use App\Filament\Resources\ClientResource\RelationManagers;

use App\Models\Client;
use App\Models\Faculty;
use App\Models\type_client;
use App\Models\type_document;
use App\Models\degree;

use Carbon\Carbon;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;

use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;

use Filament\Resources\Resource;

use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Actions\{ActionGroup, Action as TableAction};

use Illuminate\Database\QueryException;

use Filament\Notifications\Notification;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;


class ClientResource extends Resource
{
    protected static ?string $model = Client::class;
    protected static ?string $modelLabel = 'cliente';
    protected static ?string $navigationGroup = 'Asistencia y Test';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Clientes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('document')->label('Documento del cliente')
                    ->numeric()
                    ->required()
                    ->minLength(3)
                    ->maxLength(20)
                    ->unique(ignoreRecord: true)
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
                    ->autocapitalize('words')
                    ->alpha()
                    ->minLength(3)
                    ->maxLength(50)
                    ->placeholder('Ingrese el nombre del cliente')
                    ->helperText('Escribe el nombre del cliente.'),

                TextInput::make('surname')->label('Apellido del cliente')
                    ->required()
                    ->autocapitalize('words')
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

                Radio::make('gender')->label('Género del cliente')
                    ->options([
                        'Masculino' => 'Masculino',
                        'Femenino' => 'Femenino',
                    ])
                    ->required()
                    ->inline()
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
                    ->native(false)
                    ->closeOnDateSelection()
                    ->placeholder('Ingrese la fecha de nacimiento del cliente')
                    ->helperText('Escribe la fecha de nacimiento del cliente.'),

                Select::make('degree_id')->label('Grado del cliente')
                    ->placeholder('Seleccione el grado del cliente')
                    ->options(
                        degree::all()->pluck('name', 'id')
                    )
                    ->required()
                    ->searchable()
                    ->helperText('Seleccione el grado del cliente.'),
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
                    ->boolean()
                    ->label('Estado'),
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                TextColumn::make('surname')
                    ->label('Apellido')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('birth_date')
                    ->label('Fecha de nacimiento')
                    ->searchable()
                    ->date('j/M/Y')
                    ->toggleable(),
                TextColumn::make('degree.name')
                    ->label('Grado')
                    ->searchable()
                    ->wrap()
                    ->toggleable(),
                TextColumn::make('degree.typeDegree.name')
                    ->label('Tipo de grado')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('degree.faculty.name')
                    ->label('Facultad')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('height')
                    ->label('Altura (cm)')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('weight')
                    ->label('Peso (kg)')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('degree.faculty.name')
                    ->label('Facultad')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('gender')
                    ->label('Género')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('attendances_count')
                    ->label('Asistencias')
                    ->sortable()
                    ->counts('attendances')
                    ->summarize([
                        Sum::make()
                            ->label('Total')

                    ]),

            ])->defaultSort('id', 'desc')

            ->actions([

                TableAction::make('suscription_add')
                    ->label('')
                    ->icon('heroicon-o-currency-dollar')
                    ->iconButton()
                    ->tooltip('Suscribir cliente')
                    ->action(function (Client $client) {
                        try {
                            $client->pay()->create([
                                'client_id' => $client->id,
                            ]);
                            $client->update([
                                'active' => true,
                            ]);
                            Notification::make()
                                ->title('Suscripción activada.')
                                ->icon('heroicon-o-currency-dollar')
                                ->body('El cliente ' . $client->name . ' ' . $client->surname . ' ha sido suscrito.')
                                ->iconColor('primary')
                                ->send();
                        } catch (QueryException $e) {
                            if ($e->getCode() == 23000) {
                                Notification::make()
                                    ->title('Alerta')
                                    ->body('El cliente ' . $client->name . ' ' . $client->surname . ' ya tiene una suscripción activa.')
                                    ->danger()
                                    ->send();
                                return back()->with('error', 'Entrada duplicada para el cliente y la fecha de suscripción.');
                            }
                            throw $e;
                        }
                    }
                    ),

                TableAction::make('attendance_add')
                    ->label('')
                    ->icon('heroicon-o-hand-thumb-up')
                    ->iconButton()
                    ->tooltip('Agregar asistencia')
                    ->action(function (Client $client) {

                        try {
                            $client->attendances()->create([
                                'client_id' => $client->id,
                                Notification::make()
                                    ->title('Asistencia agregada.')
                                    ->body('Para el cliente ' . $client->name . ' ' . $client->surname . '.')
                                    ->success()
                                    ->send()
                            ]);
                        } catch (QueryException $e) {
                            if ($e->getCode() == 23000) {
                                Notification::make()
                                    ->title('Alerta')
                                    ->body('El cliente ' . $client->name . ' ' . $client->surname . ' ya tiene una asistencia el día de hoy.')
                                    ->warning()
                                    ->send();
                                return back()->with('error', 'Entrada duplicada para el cliente y la fecha de asistencia.');
                            }
                            throw $e;
                        }

                    }
                ),
                TableAction::make('attendance_remove')
                    ->label('')
                    ->icon('heroicon-o-hand-thumb-down')
                    ->iconButton()
                    ->tooltip('Eliminar asistencia')
                    ->action(function (Client $client) {
                        try {
                            $client->attendances()
                                ->where('date_attendance', Carbon::today())
                                ->delete();
                                Notification::make()
                                ->title('Asistencia eliminada.')
                                ->body('Para el cliente ' . $client->name . ' ' . $client->surname . '.')
                                ->success()
                                ->send();
                        } catch (QueryException $e) {
                            if ($e->getCode() == 23000 or $e->getCode() == 22007) {
                                Notification::make()
                                    ->title('Alerta')
                                    ->body('El cliente ' . $client->name . ' ' . $client->surname . ' no tiene una asistencia el día de hoy.')
                                    ->warning()
                                    ->send();
                                return back()->with('error', 'Entrada duplicada para el cliente y la fecha de asistencia.');
                            }
                            throw $e;
                        }
                    }),
                ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->icon('heroicon-o-wrench')
                        ->color('primary')
                        ->label('Editar cliente'),
                    Tables\Actions\DeleteAction::make()
                        ->icon('heroicon-o-trash')
                        ->label('Eliminar cliente'),
                ])->icon('heroicon-o-chevron-double-down')

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->label('Exportar a Excel')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('primary'),
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
                SelectFilter::make('degree_id')
                    ->label('Grado')
                    ->multiple()
                    ->options(
                        degree::all()->pluck('name', 'id')
                    )
                    ->searchable()
                    ->default(null),
                SelectFilter::make('degree.faculty_id')
                    ->label('Facultad')
                    ->multiple()
                    ->options(
                        Faculty::all()->pluck('name', 'id')
                    ),
                TernaryFilter::make('active')
                    ->label('Suscripción')
                    ->placeholder('Todos los clientes')
                    ->trueLabel('Clientes con suscripción activa')
                    ->falseLabel('Clientes con suscripción inactiva'),

            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Información del cliente')
                ->description('En esta sección se muestra la información detallada del cliente.')
                ->columns([
                    'sm' => 2,
                    'md' => 3,
                    'xl' => 4,
                ])
                ->icon('heroicon-o-user')
                ->schema([
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
                        ->label('Fecha de nacimiento')
                        ->icon('heroicon-o-calendar')
                        ->date('j/M/Y'),

                    TextEntry::make('birth_date')
                        ->label('Edad')
                        ->icon('heroicon-o-cake')
                        ->suffix(' años')
                        ->date(Carbon::parse($infolist->record->birth_date)->age )
                    ,

                    TextEntry::make('degree.name')
                        ->label('Grado')
                        ->icon('heroicon-o-academic-cap'),

                    TextEntry::make('gender')
                        ->label('Género')
                        ->icon('heroicon-o-users'),

                    TextEntry::make('height')
                        ->label('Altura')
                        ->suffix(' cm')
                        ->icon('heroicon-o-arrows-up-down'),

                    TextEntry::make('weight')
                        ->label('Peso')
                        ->suffix(' kg')
                        ->icon('heroicon-o-scale'),

                    TextEntry::make('typeClient.name')
                        ->label('Tipo de cliente')
                        ->icon('heroicon-o-user-group'),

                    TextEntry::make('typeDocument.name')
                        ->label('Tipo de documento')
                        ->icon('heroicon-o-identification'),
                ])
                    ->collapsible()
                    ->collapsed(),
                Section::make('Resumen de test')
                    ->description('En esta sección se muestra el resumen de los test realizados al cliente.')
                    ->columns([
                        'sm' => 3,
                    ])
                    ->icon('heroicon-o-clipboard-document-list')
                    ->schema([
                        Fieldset::make('Fuerza')
                            ->schema([
                                TextEntry::make('testForce')
                                    ->label('Test de fuerza')
                                    ->getStateUsing(function (Client $client) {
                                        $testForce = $client->testForce()->latest('date')->first();
                                        if ($testForce) {
                                            return $testForce['relationUpperLowerLimbs'] . ' %';
                                        }
                                        return 'No se ha realizado el test.';
                                    }),

                                TextEntry::make('testAnthropometry')
                                    ->label('Test de antropometría')
                                    ->listWithLineBreaks()
                                    ->getStateUsing(function (Client $client) {
                                        $testAnthropometry = $client->testAnthropometry()->latest('date')->first();
                                        if ($testAnthropometry) {
                                            return [$testAnthropometry['fatPercentage'] . '% porcentaje de grasa.', $testAnthropometry['IMC'] . ' IMC', $testAnthropometry['healthyWeight'] . ' kg peso saludable'];
                                        }
                                        return 'No se ha realizado el test.';
                                    }),

                                TextEntry::make('testForestry')
                                    ->label('Test de forestery')
                                    ->getStateUsing(function (Client $client) {
                                        $testForestry = $client->testForestry()->latest('date')->first();
                                        if ($testForestry) {
                                            return $testForestry['VO2'] . ' ml/kg/min';
                                        }
                                        return 'No se ha realizado el test.';
                                    }),
                            ])
                            ->columns([
                                'sm' => 3,
                                'md' => 3,
                                'xl' => 3,
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed()

                ,

            ]);

    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AttendancesRelationManager::class,
            RelationManagers\TestForceRelationManager::class,
            RelationManagers\TestAnthropometryRelationManager::class,
            RelationManagers\TestForestryRelationManager::class,

        ];
    }

    public static function getWidgets(): array
    {
        return [
            Widgets\AttendanceOverview::class,
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageClients::route('/'),
            'view' => Pages\ViewClient::route('/{record}/view'),
        ];
    }
}
