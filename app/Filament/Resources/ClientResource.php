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

use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Actions\{ActionGroup, Action as TableAction};

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;

use Filament\Notifications\Notification;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;


class ClientResource extends Resource
{
    protected static ?string $model = Client::class;
    protected static ?string $modelLabel = 'usuario';
    protected static ?string $pluralModelLabel = 'usuarios';
    protected static ?string $navigationGroup = 'Asistencia y Test';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Usuarios';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('document')->label('Documento')
                    ->numeric()
                    ->required()
                    ->minLength(3)
                    ->maxLength(20)
                    ->unique(ignoreRecord: true)
                    ->placeholder('Ingrese el número'),

                Select::make('type_document_id')->label('Tipo de documento')
                    ->placeholder('Seleccione el tipo de documento')
                    ->options(
                        type_document::all()->pluck('name', 'id')
                    )
                    ->required()
                    ->default(1)
                    ->helperText('Seleccione el tipo de documento.'),

                TextInput::make('name')->label('Nombres')
                    ->required()
                    ->minLength(3)
                    ->maxLength(50)
                    ->placeholder('Ingrese el nombre'),

                TextInput::make('surname')->label('Apellidos')
                    ->required()
                    ->minLength(3)
                    ->maxLength(50)
                    ->placeholder('Ingrese el apellido del usuario'),

                TextInput::make('email')->label('Correo electrónico')
                    ->required()
                    ->minLength(3)
                    ->maxLength(50)
                    ->unique(ignoreRecord: true)
                    ->placeholder('Ingrese el correo electrónico del usuario'),

                DatePicker::make('birth_date')->label('Fecha de nacimiento')
                    ->required()
                    // ->native(false)
                    ->closeOnDateSelection()
                    ->displayFormat('d/m/Y')
                    // ->maxDate(Carbon::now()->subYears(10))
                    ->default(Carbon::now()->subYears(18))
                    ->placeholder('Ingrese la fecha de nacimiento del usuario'),

                //

                // TextInput::make('height')->label('Estatura del usuario')
                //     ->numeric()
                //     // ->minLength(2)
                //     // ->maxLength(3)
                //     ->inputMode('decimal')
                //     ->placeholder('Ingrese la altura del usuario en CM')
                //     ->helperText('Ejemplo: 170'),

                // TextInput::make('weight')->label('Peso del usuario')
                //     ->numeric()
                //     // ->minLength(2)
                //     // ->maxLength(4)
                //     ->inputMode('decimal')
                //     ->placeholder('Ingrese el peso del usuario en KG')
                //     ->helperText('Ejemplo: 70'),

                Radio::make('gender')->label('Género')
                    ->options([
                        'Masculino' => 'Masculino',
                        'Femenino' => 'Femenino',
                    ])
                    ->required(),

                //

                Select::make('type_client_id')->label('Tipo de usuario')
                    ->placeholder('Seleccione el tipo de usuario')
                    ->options(
                        type_client::all()->pluck('name', 'id')
                    )
                    ->required()
                    ->searchable()
                    ->hint('Este determina el costo de la suscripción.')
                    ->default(1),

                Select::make('degree_id')->label('Grado del usuario')
                    ->placeholder('Seleccione el grado del usuario')
                    ->options(
                        degree::all()->pluck('name', 'id')
                    )
                    ->required()
                    ->searchable(),
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
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('degree.name')
                    ->label('Grado')
                    ->searchable()
                    ->wrap()
                    ->toggleable(),
                TextColumn::make('degree.typeDegree.name')
                    ->label('Tipo de grado')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('email')
                    ->label('Correo electrónico')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('typeClient.name')
                    ->label('Tipo de usuario')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                    ->tooltip('Suscribir usuario')
                    ->action(function (Client $client) {
                        try {
                            if ($client['active'] == true)
                            {
                                Notification::make()
                                    ->title('Alerta')
                                    ->body('El usuario ' . $client->name . ' ' . $client->surname . ' ya tiene una suscripción activa.')
                                    ->danger()
                                    ->send();
                                return back()->with('error', 'Entrada duplicada para el usuario y la fecha de suscripción.');
                            }
                            else{
                                $client->pay()->create([
                                    'client_id' => $client->id,
                                ]);
                                $client->update([
                                    'active' => true,
                                ]);
                                Notification::make()
                                    ->title('Suscripción activada.')
                                    ->icon('heroicon-o-currency-dollar')
                                    ->body('El usuario ' . $client->name . ' ' . $client->surname . ' ha sido suscrito.')
                                    ->iconColor('primary')
                                    ->send();
                            }

                        } catch (QueryException $e) {
                            if ($e->getCode() == 23000) {
                                Notification::make()
                                    ->title('Alerta')
                                    ->body('El usuario ' . $client->name . ' ' . $client->surname . ' ya tiene una suscripción activa.')
                                    ->danger()
                                    ->send();
                                return back()->with('error', 'Entrada duplicada para el usuario y la fecha de suscripción.');
                            }
                            throw $e;
                        }
                        return back()->with('success', 'Suscripción agregada correctamente.');
                    }
                    ),

                TableAction::make('attendance_add')
                    ->label('')
                    ->icon('heroicon-o-hand-thumb-up')
                    ->iconButton()
                    ->tooltip('Agregar asistencia')
                    ->action(function (Client $client) {

                        try {
                            if ($client->attendances()->where('date_attendance', Carbon::today())->count() == 0 and $client['active'] == true)
                            {
                                $client->attendances()->create([
                                    'client_id' => $client->id,

                                ]);
                                Notification::make()
                                    ->title('Asistencia agregada.')
                                    ->body('Para el usuario ' . $client->name . ' ' . $client->surname . '.')
                                    ->success()
                                    ->send();
                                return back()->with('success', 'Asistencia agregada correctamente.');
                            }
                            elseif (!$client['active']){
                                Notification::make()
                                    ->title('Alerta')
                                    ->body('El usuario ' . $client->name . ' ' . $client->surname . ' no tiene una suscripción activa.')
                                    ->danger()
                                    ->send();
                                return back()->with('error', 'Entrada duplicada para el usuario y la fecha de asistencia.');
                            }
                            else{
                                Notification::make()
                                    ->title('Alerta')
                                    ->body('El usuario ' . $client->name . ' ' . $client->surname . ' ya tiene una asistencia el día de hoy.')
                                    ->warning()
                                    ->send();
                                return back()->with('error', 'Entrada duplicada para el usuario y la fecha de asistencia.');
                            }
                        } catch (QueryException $e) {
                            if ($e->getCode() == 23000) {
                                return back()->with('error', 'Entrada duplicada para el usuario y la fecha de asistencia.');
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
                            if ($client->attendances()->where('date_attendance', Carbon::today())->count() != 0 and $client['active'] == true) {
                                $client->attendances()
                                    ->where('date_attendance', Carbon::today())
                                    ->delete();
                                Notification::make()
                                    ->title('Asistencia eliminada.')
                                    ->body('Para el usuario ' . $client->name . ' ' . $client->surname . '.')
                                    ->success()
                                    ->send();
                                return back()->with('success', 'Asistencia eliminada correctamente.');
                            }
                            elseif (!$client['active']){
                                Notification::make()
                                    ->title('Alerta')
                                    ->body('El usuario ' . $client->name . ' ' . $client->surname . ' no tiene una suscripción activa.')
                                    ->danger()
                                    ->send();
                                return back()->with('error', 'Entrada duplicada para el usuario y la fecha de asistencia.');
                            }
                            else {
                                Notification::make()
                                    ->title('Alerta')
                                    ->body('El usuario ' . $client->name . ' ' . $client->surname . ' no tiene una asistencia el día de hoy.')
                                    ->warning()
                                    ->send();
                                return back()->with('error', 'Entrada duplicada para el usuario y la fecha de asistencia.');
                            }
                        } catch (QueryException $e) {
                            if ($e->getCode() == 23000 or $e->getCode() == 22007) {
                                Notification::make()
                                    ->title('Alerta')
                                    ->body('El usuario ' . $client->name . ' ' . $client->surname . ' no tiene una asistencia el día de hoy.')
                                    ->warning()
                                    ->send();
                                return back()->with('error', 'Entrada duplicada para el usuario y la fecha de asistencia.');
                            }
                            throw $e;
                        }
                    }),
                ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->icon('heroicon-o-wrench')
                        ->color('primary')
                        ->label('Editar usuario'),
                    Tables\Actions\DeleteAction::make()
                        ->icon('heroicon-o-trash')
                        ->label('Eliminar usuario'),
                ])->icon('heroicon-o-chevron-double-down')

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
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
                    ->label('Tipo de usuario')
                    ->multiple()
                    ->options(
                        fn (): array =>
                        type_client::all()->pluck('name', 'id')->all()
                    )
                    ->searchable()
                    ->default(null),

                SelectFilter::make('type_document_id')
                    ->label('Tipo de documento')
                    ->multiple()
                    ->options(
                        fn (): array =>
                        type_document::all()->pluck('name', 'id')->all()
                    )
                    ->searchable()
                    ->default(null),

                SelectFilter::make('degree_id')
                    ->label('Grado')
                    ->multiple()
                    ->options(
                        fn (): array =>
                        degree::all()->pluck('name', 'id')->all()
                    )
                    ->searchable()
                    ->default(null),

                Filter::make('faculty')
                    ->form([
                        Select::make('faculty_id')
                            ->label('Facultad')
                            ->multiple()
                            ->options(
                                fn (): array =>
                                Faculty::all()->pluck('name', 'id')->all()
                            )
                            ->preload()
                            ->searchable()
                            ->default(null),
                    ])->query(function (Builder $query, array $data) {
                        if (isset($data['faculty_id']) && $data['faculty_id'] != null) {
                            return $query->whereHas('degree', function (Builder $query) use ($data) {
                                $query->whereIn('faculty_id', $data['faculty_id']);
                            });
                        }
                        return $query;
                    })->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['faculty_id'] ?? null) {
                            $facultyNames = Faculty::whereIn('id', $data['faculty_id'])->pluck('name')->all();
                            $indicators[] = 'Facultad: ' . implode(' & ', $facultyNames);
                        }
                        return $indicators;
                    }),

                SelectFilter::make('gender')
                    ->label('Género')
                    ->options([
                        'Masculino' => 'Masculino',
                        'Femenino' => 'Femenino',
                    ])
                    ->default(null),

                TernaryFilter::make('active')
                    ->label('Suscripción')
                    ->placeholder('Todos los usuarios')
                    ->trueLabel('Usuarios con suscripción activa')
                    ->falseLabel('Usuarios con suscripción inactiva'),

                Filter::make('between_dates')
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
                    ])->columns(2)
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['date_from'] ?? null) {
                            $indicators[] = 'Fecha: desde ' . Carbon::parse($data['date_from'])->format('j/M/Y');
                        }
                        if ($data['date_to'] ?? null) {
                            if ($indicators != null) {
                                $indicators[] = 'Rango de fechas: desde ' . Carbon::parse($data['date_from'])->format('j/M/Y') . ' & hasta ' . Carbon::parse($data['date_to'])->format('j/M/Y');
                            }
                            else{
                                $indicators[] = 'Fecha: hasta ' . Carbon::parse($data['date_to'])->format('j/M/Y');
                            }
                        }

                        return $indicators;

                    })
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when(
                                $data['date_from'] ?? null,
                                fn (Builder $query, $date) => $query->whereHas('pay', function (Builder $query) use ($date) {
                                    $query->where('start_date', '>=', $date);
                                }),
                            )
                            ->when(
                                $data['date_to'] ?? null,
                                fn (Builder $query, $date) => $query->whereHas('pay', function (Builder $query) use ($date) {
                                    $query->where('start_date', '<=', $date);
                                }),
                            );

                    }),

            ])
            ->filtersFormColumns(3)
            ->poll('5s')
            ->paginated([10, 50, 100, 200])
            ->defaultPaginationPageOption(10);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make([
                    TextEntry::make('document')
                    ->label('Documento')
                    ->badge()
                    ->color('success')
                    ->copyable()
                    ->copyMessage('Copiado al portapapeles.')
                    ->copyMessageDuration(1500)
                    ->icon('heroicon-o-identification'),

                    TextEntry::make('name')
                        ->label('Nombre')
                        ->icon('heroicon-o-user'),

                    TextEntry::make('surname')
                        ->label('Apellido')
                        ->icon('heroicon-o-user'),
                    
                    IconEntry::make('active')
                    ->label('Estado')
                    ->boolean(),

                    TextEntry::make('degree.name')
                        ->label('Grado')
                        ->icon('heroicon-o-academic-cap'),

                    TextEntry::make('birth_date')
                        ->label('Fecha de nacimiento')
                        ->icon('heroicon-o-calendar')
                        ->date('j/M/Y'),

                    TextEntry::make('birth_date')
                        ->label('Edad')
                        ->icon('heroicon-o-cake')
                        ->suffix(' años')
                        ->date(Carbon::parse($infolist->record->birth_date)->age ),

                    TextEntry::make('gender')
                        ->label('Género')
                        ->icon('heroicon-o-users'),

                    TextEntry::make('height')
                        ->label('Altura')
                        ->icon('heroicon-o-arrows-up-down')
                        ->getStateUsing(function (Client $client) {
                            if ($client->height != null) {
                                return $client['height'] . ' cm';
                            }
                            return 'No se ha ingresado una estatura.';
                        }),

                    TextEntry::make('weight')
                        ->label('Peso')
                        ->icon('heroicon-o-scale')
                        ->getStateUsing(function (Client $client) {
                            if ($client->weight != null) {
                                return $client['weight'] . ' kg';
                            }
                            return 'No se ha ingresado un peso.';
                        }),
                    ])
                    ->heading('Información del usuario')
                ->description('En esta sección se muestra la información detallada del usuario.')
                ->columns([
                    'sm' => 1,
                    'md' => 2,
                    'lg' => 3,
                ])
                ->columnSpan(1)
                ->icon('heroicon-o-user')
                    ->collapsible()
                    ->collapsed(),
                Section::make([
                    Fieldset::make('Resumen de los ultimos test')
                        ->schema([
                            TextEntry::make('testForce')
                                ->label('Test de fuerza')
                                ->tooltip('Relación tren superior e inferior')
                                ->alignment(Alignment::Center)
                                ->hint($infolist->record->testForce()->latest('date')->first()['date'] ?? '')
                                ->getStateUsing(function (Client $client) {
                                    $testForce = $client->testForce()->latest('id')->first();
                                    if ($testForce) {
                                        return $testForce['relationUpperLowerLimbs'] . ' %';
                                    }
                                    return 'No se ha realizado el test.';
                                }),

                            TextEntry::make('testAnthropometry')
                                ->label('Test de antropometría')
                                ->tooltip('Porcentaje de grasa, IMC y peso saludable')
                                ->alignment(Alignment::Center)
                                ->hint($infolist->record->testAnthropometry()->latest('date')->first()['date'] ?? '')
                                ->listWithLineBreaks()
                                ->getStateUsing(function (Client $client) {
                                    $testAnthropometry = $client->testAnthropometry()->latest('id')->first();
                                    if ($testAnthropometry) {
                                        return [$testAnthropometry['fatPercentage'] . '% porcentaje de grasa', $testAnthropometry['IMC'] . ' IMC', $testAnthropometry['healthyWeight'] . ' kg peso saludable'];
                                    }
                                    return 'No se ha realizado el test.';
                                }),

                            TextEntry::make('testForestry')
                                ->label('Test de forestery')
                                ->tooltip('VO2max')
                                ->alignment(Alignment::Center)
                                ->hint($infolist->record->testForestry()->latest('date')->first()['date'] ?? '')
                                ->getStateUsing(function (Client $client) {
                                    $testForestry = $client->testForestry()->latest('id')->first();
                                    if ($testForestry) {
                                        return $testForestry['VO2max'] . ' ml/kg/min';
                                    }
                                    return 'No se ha realizado el test.';
                                }),
                        ])
                        ->columns([
                            'sm' => 1,
                            'md' => 1,
                            'xl' => 1,
                        ])
                ])
                    ->heading('Resumen de los últimos test')
                    ->description('En esta sección se muestra el resumen de los test realizados al usuario.')
                    
                    ->icon('heroicon-o-clipboard-document-list')
                    ->collapsible()
                    ->collapsed()
                    ->columnSpan(1),

                    Section::make([
                      Fieldset::make('Calculadora')
                          // ->schema([
                          //     TextInput::make('number1')
                          //         ->label('Primer número')
                          //         ->required(),
                  
                          //     TextInput::make('number2')
                          //         ->label('Segundo número')
                          //         ->required(),
                  
                          //     TextInput::make('result')
                          //         ->label('Resultado')
                          //         ->reactive() // Use reactive instead of stateful
                          //         ->readonly(),
                          // ])
                          ->columns([
                              'sm' => 1,
                              'md' => 1,
                              'xl' => 1,
                              '2xl' => 1,
                          ])
                  ])
                  ->heading('Calculadora')
                  ->description('En esta sección se muestra una calculadora simple para sumar dos números.')
                  ->icon('heroicon-o-calculator')
                  ->collapsible()
                  ->collapsed()
                  ->columnSpan(1),
                  
               
                

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
