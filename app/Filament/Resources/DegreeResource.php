<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DegreeResource\Pages;
use App\Filament\Resources\DegreeResource\RelationManagers;
use App\Models\degree;
use App\Models\type_degree;
use App\Models\Faculty;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class DegreeResource extends Resource
{
    protected static ?string $model = degree::class;

    protected static ?string $modelLabel = 'grado';
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Mantenimiento';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Nombre de la carrera')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->minLength(2)
                    ->maxLength(255)
                    ->placeholder('Ingrese el nombre de la carrera')
                    ->helperText('Escribe el nombre de la carrera.')
                    ->hint('El nombre debe ser único.'),
                Select::make('type_degree_id')->label('Tipo de grado')
                    ->placeholder('Seleccione el tipo de grado')
                    ->options(
                        type_degree::all()->pluck('name', 'id')
                    )
                    ->required()
                    ->searchable()
                    ->helperText('Seleccione el tipo de grado.'),
                Select::make('faculty_id')->label('Facultad')
                    ->placeholder('Seleccione la facultad')
                    ->options(
                        \App\Models\Faculty::all()->pluck('name', 'id')
                    )
                    ->required()
                    ->searchable()
                    ->helperText('Seleccione la facultad.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('typeDegree.name')->label('Tipo de grado')->searchable(),
            ])
            ->filters([
                SelectFilter::make('type_degree_id')->label('Tipo de grado')
                    ->options(
                        type_degree::all()->pluck('name', 'id')
                    ),
                SelectFilter::make('faculty_id')->label('Facultad')
                    ->options(
                        Faculty::all()->pluck('name', 'id')
                    ),
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
            'index' => Pages\ListDegrees::route('/'),
            'create' => Pages\CreateDegree::route('/create'),
            'edit' => Pages\EditDegree::route('/{record}/edit'),
        ];
    }
}
