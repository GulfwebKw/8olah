<?php

namespace App\Filament\Resources\Panel;

use App\Filament\Resources\Panel\AdminResource\Pages;
use App\Filament\Resources\Panel\AdminResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class AdminResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-user';
    protected static ?int $navigationSort = 4;

    protected static ?string $label = 'Admin';

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
                        Forms\Components\TextInput::make('email')
                            ->maxLength(255)
                            ->unique(User::class , 'email' , null,true )
                            ->nullable(),
                        Forms\Components\TextInput::make('phone')
                            ->maxLength(12)
                            ->numeric()
                            ->unique(User::class , 'phone' , null,true )
                            ->required(),
                        Forms\Components\Checkbox::make('is_active')
                            ->inline(),
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
                Tables\Columns\BooleanColumn::make('is_active')
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
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
