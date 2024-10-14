<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Hidden::make('id'),

                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(fn ($record) => $record === null)
                    ->maxLength(255),

                Checkbox::make('admin')
                    ->label('Is Admin')
                    ->default(false),

                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => !empty($state) ? \Hash::make($state) : null)
                    ->dehydrated(fn ($state) => filled($state))
                    ->label('Password')
                    ->helperText('Leave blank to keep the current password.')
                    ->minLength(8)
                    ->same('passwordConfirmation')
                    ->required(fn ($record) => $record === null), // Required on create, optional on edit

                TextInput::make('passwordConfirmation')
                    ->password()
                    ->label('Confirm Password')
                    ->minLength(8)
                    ->dehydrated(false), 
                
                TextInput::make('presents')
                    ->label('Presents')
                    ->numeric()
                    ->minValue(0)
                    ->required()
                    ->default(0),

                TextInput::make('total')
                    ->label('Total Lectures')
                    ->numeric()
                    ->minValue(0)
                    ->required()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable()->sortable(),
                Tables\Columns\IconColumn::make('admin')
                    ->boolean()
                    ->label('Admin')
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->dateTime('M d, Y'),
                Tables\Columns\TextColumn::make('presents')
                    ->label('Presents')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total Lectures')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }    
}
