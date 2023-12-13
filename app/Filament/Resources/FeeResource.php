<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeeResource\Pages;
use App\Filament\Resources\FeeResource\RelationManagers;
use App\Models\Client;
use App\Models\Pay;
use App\Models\type_client;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
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
    protected static ?string $pluralModelLabel = 'tarifas';

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
                    ->unique(ignoreRecord: true)
                    ->hint('El nombre debe ser único.'),
                TextInput::make('fee')->label('Tarifa')
                    ->required()
                    ->minLength(2)
                    ->maxLength(255)
                    ->placeholder('Ingrese la tarifa')
                    ->helperText('Escribe la tarifa.')
                    ->autocomplete(false),
                TextInput::make('months')->label('Meses')
                    ->required()
                    ->maxLength(1)
                    ->placeholder('Ingrese los meses')
                    ->helperText('Escribe los meses.')
                    ->autocomplete(false),
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
            ])->headerActions([
                Tables\Actions\Action::make('restoreStatus')
                    ->label('Reiniciar suscripciones')
                    ->icon('heroicon-o-arrow-path')
                    ->color('primary')
                    ->action(function () {
                        if (Client::where('active', true)->count() == 0) {
                            Notification::make()
                                ->title('No hay clientes activos.')
                                ->body('En este momento no hay clientes activos.')
                                ->danger()
                                ->send();
                            return back()->with('error', 'No hay clientes activos.');
                        } else {
                            $clientsNotParticular = Client::where('type_client_id', '!=', 5)->get();
                            foreach ($clientsNotParticular as $client) {
                                Client::where('id', $client->id)->update(['active' => false]);
                                Pay::where('client_id', $client->id)->where('start_date', '>=', Carbon::today())->update(['start_date' => Carbon::yesterday()]);
                                Pay::where('client_id', $client->id)->where('end_date', '>=', Carbon::today())->update(['end_date' => Carbon::yesterday()]);
                            }
                            Notification::make()
                                ->title('Suscripciones reiniciadas.')
                                ->body('Se han reiniciado las suscripciones de los clientes.')
                                ->success()
                                ->send();
                            return back()->with('success', 'Suscripciones reiniciadas correctamente.');

                        }

                    }),

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
            'index' => Pages\ListFees::route('/'),
            'create' => Pages\CreateFee::route('/create'),
            'edit' => Pages\EditFee::route('/{record}/edit'),
        ];
    }
}
