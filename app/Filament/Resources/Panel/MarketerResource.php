<?php

namespace App\Filament\Resources\Panel;

use App\Filament\Resources\Panel\MarketerResource\Pages;
use App\Filament\Resources\Panel\MarketerResource\RelationManagers;
use App\Models\Marketer;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class MarketerResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-users';
    protected static ?int $navigationSort = 3;

    protected static ?string $label = 'Marketer';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name' , 'username'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return new HtmlString($record->name . '<small> ('.$record->username.')</small>');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('username')
                            ->maxLength(255)
                            ->unique(User::class , 'username' , null,true )
                            ->required(),
                        Forms\Components\TextInput::make('commission_per_work')
                            ->numeric()
                            ->required(),
                        Forms\Components\Checkbox::make('is_active')
                            ->inline(),
                    ])->columns(2),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('bank_name')
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('bank_number')
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('bank_iban')
                            ->maxLength(255)
                            ->required(),
                    ])->columns(2),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->nullable()
                            ->confirmed()
                            ->helperText("Set empty if you do not need change password!")
                            ->type('password'),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->nullable()
                            ->type('password'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('commission_per_work')
                    ->sortable(),
                Tables\Columns\BooleanColumn::make('is_active')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('id' , 'desc');
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
            'index' => Pages\ListMarketers::route('/'),
            'create' => Pages\CreateMarketer::route('/create'),
            'edit' => Pages\EditMarketer::route('/{record}/edit'),
            'view' => Pages\ViewMarketers::route('/{record}'),
        ];
    }
}
