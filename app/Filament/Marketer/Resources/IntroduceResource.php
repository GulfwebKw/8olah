<?php

namespace App\Filament\Marketer\Resources;

use App\Filament\Marketer\Resources\IntroduceResource\Pages;
use App\Filament\Marketer\Resources\IntroduceResource\RelationManagers;
use App\Models\Introduce;
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

class IntroduceResource extends Resource
{
    protected static ?string $model = Introduce::class;

    protected static ?string $navigationIcon = 'heroicon-m-shopping-bag';
    protected static ?int $navigationSort = 1;
    public static function getLabel(): string
    {
        return __('Introduce');
    }
    public static function getPluralLabel(): string
    {
        return __('Introduces');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('customer_name')
                            ->label(__('customer_name'))
                            ->required(),
                        Forms\Components\TextInput::make('customer_phone')
                            ->label(__('customer_phone'))
                            ->required(),
                        Forms\Components\TextInput::make('number_works')
                            ->label(__('number_works'))
                            ->required(),
                        Forms\Components\Placeholder::make('number_works_approved')
                            ->label(__('number_works_approved'))
                            ->content(fn ($record) => $record?->number_works_approved ?? __('Not Set Yet!'))
                            ->hidden(fn($record) => is_null($record)),
                        Forms\Components\Textarea::make('description')
                            ->label(__('description')),
                        Forms\Components\Placeholder::make('admin_description')
                            ->label(__('admin_description'))
                            ->content(fn ($record) => new HtmlString(nl2br($record?->admin_description)))
                            ->hidden(fn($record) => is_null($record?->admin_description)),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('id'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label(__('customer_name'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_phone')
                    ->label(__('customer_phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('number_works')
                    ->label(__('number_works'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('number_works_approved')
                    ->label(__('number_works_approved'))
                    ->sortable(),
                Tables\Columns\BooleanColumn::make('is_earned')
                    ->label(__('settled'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListIntroduces::route('/'),
            'create' => Pages\CreateIntroduce::route('/create'),
            'edit' => Pages\EditIntroduce::route('/{record}/edit'),
            'view' => Pages\ViewIntroduce::route('/{record}'),
        ];
    }
}
