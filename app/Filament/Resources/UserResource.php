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
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel = 'Manajemen User';

        public static function canViewAny(): bool
        {
             return Auth::user()->role === 'admin';
        }
    


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('logo')
                    ->label('Logo Toko')
                    ->image()
                    ->required(),

                Forms\Components\TextInput::make('name')
                    ->label('Nama Toko')
                    ->required(),

                Forms\Components\TextInput::make('username')
                    ->label('username')
                    ->hint('minimal 5 karakter, tidak boleh ada spasi')
                    ->minLength(5)
                    ->Unique(User::class, 'username', ignoreRecord: true)
                    ->required(),


                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->Email()
                    ->Unique(User::class, 'email', ignoreRecord: true)
                    ->required(),

                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrated()
                    ->required(),

                Forms\Components\Select::make('role')
                    ->label('Peran')
                    ->Options([
                        'admin' => 'Admin',
                        'store' => 'Toko'
                    ])
                    ->required(),
            ]);
            
    }

    public static function table(Table $table): Table
    {
        return $table
           ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo Toko'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Toko'),
                Tables\Columns\TextColumn::make('username')
                    ->label('Username'),
                Tables\Columns\TextColumn::make('email')
                    ->label('email'),
                Tables\Columns\TextColumn::make('role')
                    ->label('peran'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Tanggal Mendaftar'),
                Tables\Columns\TextColumn::make(''),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
