<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DailyTallyResource\Pages;
use App\Filament\Resources\DailyTallyResource\RelationManagers;
use App\Models\DailyTally;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DailyTallyResource extends Resource
{
    protected static ?string $model = DailyTally::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        $columnsConfig = config('columns.columns');

        $schema = [
            Select::make('user_id')
                ->label('User')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),
            DatePicker::make('date')
                ->label('Date')
                ->required(),
        ];

        foreach ($columnsConfig as $field => $details) {
            $schema[] = TextInput::make($field)
                ->label($details['label'] ?? ucfirst($field))
                ->numeric()
                ->default(0)
                ->required();
        }

        return $form->schema($schema);
    }

    public static function table(Table $table): Table
    {   
        $columnsConfig = config('columns.columns');

        $columns = [
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('user.name')->label('User')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('date')->sortable()->date(),
        ];

        foreach ($columnsConfig as $field => $details) {
            $columns[] = Tables\Columns\TextColumn::make($field)
                ->label($details['label'] ?? ucfirst($field))
                ->sortable();
        }

        return $table
            ->columns($columns)
            ->filters([
                // Define any table filters if needed
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
            'index' => Pages\ListDailyTallies::route('/'),
            'create' => Pages\CreateDailyTally::route('/create'),
            'edit' => Pages\EditDailyTally::route('/{record}/edit'),
        ];
    }    
}
