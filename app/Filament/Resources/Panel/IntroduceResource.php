<?php

namespace App\Filament\Resources\Panel;

use App\Filament\Resources\Panel\IntroduceResource\Pages;
use App\Filament\Resources\Panel\IntroduceResource\RelationManagers;
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
use Webbingbrasil\FilamentAdvancedFilter\Filters\DateFilter;
use Webbingbrasil\FilamentAdvancedFilter\Filters\TextFilter;

class IntroduceResource extends Resource
{
    protected static ?string $model = Introduce::class;

    protected static ?string $navigationIcon = 'heroicon-m-shopping-bag';
    protected static ?int $navigationSort = 1;

    public static function getGloballySearchableAttributes(): array
    {
        return ['customer_name' , 'customer_phone'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        /** @var Introduce $record */
        return new HtmlString($record->customer_name . '<small> ('.$record->customer_phone.' - Marketer: '. $record->user->name . ')</small>');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('customer_name')
                            ->content(fn ($record) => $record->customer_name),
                        Forms\Components\Placeholder::make('customer_phone')
                            ->content(fn ($record) => $record->customer_phone),
                        Forms\Components\Placeholder::make('number_works')
                            ->content(fn ($record) => $record->number_works),
//                        Forms\Components\Placeholder::make('number_works_api')
//                            ->content(fn ($record) => $record->number_works_api ?? 'Not Set Yet!'),
                        Forms\Components\TextInput::make('number_works_approved')
                            ->numeric()
                            ->nullable(),
                        Forms\Components\Select::make('user_id')
                            ->label('Marketer')
                            ->relationship('user', 'name',
                                modifyQueryUsing: fn (Builder $query) => $query->where('is_admin' , false)->orderBy('name'),
                            )
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Placeholder::make('description')
                            ->content(fn ($record) => new HtmlString(nl2br($record->description))),
                        Forms\Components\Textarea::make('admin_description')
                            ->nullable(),
                        Forms\Components\Placeholder::make('created_at')
                            ->content(fn ($record) => $record->created_at),
                        Forms\Components\Placeholder::make('updated_at')
                            ->content(fn ($record) => $record->updated_at),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Marketer')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('number_works')
                    ->sortable(),
                Tables\Columns\TextColumn::make('number_works_approved')
                    ->sortable(),
                Tables\Columns\BooleanColumn::make('is_earned')
                    ->label('settled')
                    ->sortable(),
            ])
            ->filters([
                DateFilter::make('created_at'),
                TextFilter::make('customer_name'),
                TextFilter::make('customer_phone'),

            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            ->actions([
//                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListIntroduces::route('/'),
            'create' => Pages\CreateIntroduce::route('/create'),
            'edit' => Pages\EditIntroduce::route('/{record}/edit'),
            'view' => Pages\ViewIntroduce::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::$model;

        return (string) $modelClass::query()
            ->whereNull('number_works_approved')
            ->where('created_at', '>=' , now()->subDays(2)->startOfDay())
            ->count();
    }

}
