<?php

namespace App\Filament\Resources\Panel;

use App\Filament\Resources\Panel\CheckoutResource\Pages;
use App\Filament\Resources\Panel\CheckoutResource\RelationManagers;
use App\Models\Checkout;
use App\Models\Introduce;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use Webbingbrasil\FilamentAdvancedFilter\Filters\DateFilter;
use Webbingbrasil\FilamentAdvancedFilter\Filters\NumberFilter;
use Webbingbrasil\FilamentAdvancedFilter\Filters\TextFilter;

class CheckoutResource extends Resource
{
    protected static ?string $model = Checkout::class;

    protected static ?string $navigationIcon = 'heroicon-m-currency-dollar';
    protected static ?int $navigationSort = 2;

    public static function getGloballySearchableAttributes(): array
    {
        return ['bank_number' , 'bank_iban', 'tracking_number'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        /** @var Checkout $record */
        return new HtmlString($record->user->name . '<small> ('.$record->bank_name.' - '. $record->tracking_number . ')</small>');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Marketer')
                            ->relationship('user', 'name',
                                modifyQueryUsing: fn (Builder $query) => $query->where('is_admin' , false)->orderBy('name'),
                            )
                            ->getOptionLabelFromRecordUsing(fn (Model $record): ?string => $record?->company_name . ' ('.$record?->name.')')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(),
                        Forms\Components\Placeholder::make('bank_name')
                            ->content(fn ($record,Get $get) => $record?->bank_name ?? User::query()->find($get('user_id'))?->bank_name),
                        Forms\Components\Placeholder::make('bank_number')
                            ->content(fn ($record,Get $get) => $record?->bank_number ?? User::query()->find($get('user_id'))?->bank_number),
                        Forms\Components\Placeholder::make('bank_iban')
                            ->content(fn ($record,Get $get) => $record?->bank_iban ?? User::query()->find($get('user_id'))?->bank_iban),
                    ])->columns(2),
                Forms\Components\Section::make()
                    ->hidden(fn ($record,Get $get) => is_null($get('user_id')))
                    ->schema([
                        Forms\Components\Select::make('Introduces')
                            ->options(fn ($record , Get $get) => Introduce::query()
                                    ->when( $record?->id , function ($query) use($record) {
                                        $query->where(function ( $query) use($record) {
                                            $query->where('is_earned' , true)
                                                ->where('checkout_id' , $record?->id);
                                        })->orWhere('is_earned' , false);
                                    } , function ($query) {
                                        $query->where('is_earned' , false);
                                    })
                                    ->where('user_id' , $get('user_id'))
                                    ->orderByDesc('number_works_approved')->pluck('customer_name' ,'id')
                            )
                            ->searchable()
                            ->multiple()
                            ->preload()
                            ->helperText(fn(Get $get) => 'Total Commission is: ' . ( Introduce::query()
                                        ->whereIn("id", $get('Introduces'))
                                        ->sum('number_works_approved') * User::query()
                                        ->find($get('user_id'))?->commission_per_work )
                            )
                            ->live()
                            ->required(),
                        Forms\Components\TextInput::make('commission')
                            ->numeric()
                            ->required(),
                        Forms\Components\Select::make('checkout_type_id')
                            ->label('Type')
                            ->relationship('checkout_type', 'title')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(),
                        Forms\Components\TextInput::make('tracking_number')
                            ->required(),
                        Forms\Components\FileUpload::make('picture')
                            ->image(),
                        Forms\Components\Placeholder::make('created_at')
                            ->hidden(fn ($record) => is_null($record))
                            ->content(fn ($record) => $record->created_at),
                        Forms\Components\Placeholder::make('updated_at')
                            ->hidden(fn ($record) => is_null($record))
                            ->content(fn ($record) => $record->updated_at),
                        Forms\Components\Placeholder::make('admin.name')
                            ->label('Generator Admin')
                            ->hidden(fn ($record) => is_null($record?->admin?->name))
                            ->content(fn ($record,Get $get) => $record?->admin?->name),

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
                Tables\Columns\TextColumn::make('bank_name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tracking_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('commission')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('admin.name')
                    ->label('Generator')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable(),
            ])
            ->filters([
                DateFilter::make('created_at'),
                TextFilter::make('tracking_number'),
                NumberFilter::make('commission'),
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('id','desc');
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
            'index' => Pages\ListCheckouts::route('/'),
            'create' => Pages\CreateCheckout::route('/create'),
            'edit' => Pages\EditCheckout::route('/{record}/edit'),
            'view' => Pages\ViewCheckout::route('/{record}'),
        ];
    }
}
