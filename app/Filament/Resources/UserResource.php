<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?string $navigationGroup = 'Mantenimiento';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Nombre del usuario')
                    ->required()
                    ->minLength(2)
                    ->maxLength(255)
                    ->placeholder('Ingrese el nombre del usuario')
                    ->helperText('Escribe el nombre del usuario.')
                    ->hint('El nombre debe ser único.'),
                TextInput::make('email')->label('Correo electrónico')
                    ->required()
                    ->email()
                    ->minLength(2)
                    ->maxLength(255)
                    ->placeholder('Ingrese el correo electrónico del usuario')
                    ->helperText('Escribe el correo electrónico del usuario.')
                    ->hint('El correo electrónico debe ser único.'),
                TextInput::make('password')->label('Contraseña')
                    ->required()
                    ->minLength(8)
                    ->maxLength(255)
                    ->placeholder('Ingrese la contraseña del usuario')
                    ->helperText('Escribe la contraseña del usuario.')
                    ->hint('La contraseña debe tener al menos 8 caracteres.'),
                TextInput::make('password_verified')->label('Verificar Contraseña')
                    ->required()
                    ->minLength(8)
                    ->maxLength(255)
                    ->placeholder('Ingrese la contraseña del usuario')
                    ->helperText('Escribe la contraseña del usuario.')
                    ->hint('Las contraseñas deben coincidir.'),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email_verified_at')
                    ->searchable()
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}