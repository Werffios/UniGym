<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\Alignment;
class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = 'Administrador';
    protected static ?string $pluralModelLabel = 'Administradores';
    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationGroup = 'Mantenimiento';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nombre del administrador')
                    ->required()
                    ->minLength(2)
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->placeholder('Ingrese el nombre del administrador')
                    ->helperText('Escribe el nombre del administrador.')
                    ->autocomplete(false)
                    ->hint('El nombre debe ser único.'),
                TextInput::make('email')->label('Correo electrónico')
                    ->required()
                    ->unique()
                    ->email()
                    ->minLength(2)
                    ->maxLength(255)
                    ->placeholder('Ingrese el correo electrónico del administrador')
                    ->helperText('Escribe el correo electrónico del administrador.')
                    ->hint('El correo electrónico debe ser único.'),
                Select::make('roles')->label('Rol')
                    ->required()
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->placeholder('Seleccione el rol del administrador')
                    ->helperText('Seleccione el rol del administrador.')
                    ->hint('El rol determina los permisos del administrador.'),
                TextInput::make('password')->label('Contraseña')
                    ->password()
                    ->autocomplete('new-password')
                    ->required()
                    ->confirmed()
                    ->minLength(8)
                    ->maxLength(255)
                    ->placeholder('Ingrese la contraseña del administrador')
                    ->helperText('Escribe la contraseña del administrador.')
                    ->hint('La contraseña debe tener al menos 8 caracteres.'),
                TextInput::make('password_confirmation')->label('Confirmar contraseña')
                    ->password()
                    ->autocomplete('new-password')
                    ->required()
                    ->minLength(8)
                    ->maxLength(255)
                    ->placeholder('Ingrese la contraseña del administrador')
                    ->helperText('Escribe la contraseña del administrador.')
                    ->hint('La contraseña debe tener al menos 8 caracteres.'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                TextColumn::make('name')
                    ->label('Nombre de administrador')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Correo electrónico')
                    ->alignment(Alignment::End)
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->label('Rol')
                    ->alignment(Alignment::End)
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
