<?php

namespace App\Filament\Resources\Panel;

use App\Filament\Resources\Panel\InboxResource\Pages;
use App\Filament\Resources\Panel\InboxResource\RelationManagers;
use App\Models\Inbox;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InboxResource extends Resource
{
    protected static ?string $model = Inbox::class;

    protected static ?string $navigationIcon = 'heroicon-s-chat-bubble-left';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Marketer')
                    ->relationship('user', 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->where('is_admin' , false)->orderBy('name'),
                    )
                    ->getOptionLabelFromRecordUsing(fn (Model $record): ?string => $record?->company_name . ' ('.$record?->name.')')
                    ->preload()
                    ->live(),
                Forms\Components\Select::make('type_id')
                    ->label('Type')
                    ->relationship('type', 'title_en')
                    ->preload()
                    ->live(),
                Forms\Components\TextInput::make('vodaphone')
                    ->label('Vodaphone Number')
                    ->nullable(),
                Forms\Components\Textarea::make('message')
                    ->columnSpan(2)
                    ->rows(12),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Marketer')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type.title_en')
                    ->label('Type')
                    ->sortable(),
                Tables\Columns\BooleanColumn::make('seen')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('seen');
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
            'index' => Pages\ListInboxes::route('/'),
            'view' => Pages\ViewInbox::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::$model;

        return (string) $modelClass::query()
            ->where('seen' , false)
            ->count();
    }
}
