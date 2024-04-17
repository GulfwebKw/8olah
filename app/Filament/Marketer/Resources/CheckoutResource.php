<?php

namespace App\Filament\Marketer\Resources;

use App\Filament\Marketer\Resources\CheckoutResource\Pages;
use App\Filament\Marketer\Resources\CheckoutResource\RelationManagers;
use App\Models\Checkout;
use App\Models\Introduce;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Webbingbrasil\FilamentAdvancedFilter\Filters\DateFilter;
use Webbingbrasil\FilamentAdvancedFilter\Filters\NumberFilter;
use Webbingbrasil\FilamentAdvancedFilter\Filters\TextFilter;

class CheckoutResource extends Resource
{
    protected static ?string $model = Checkout::class;


    protected static ?string $navigationIcon = 'heroicon-m-currency-dollar';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('bank_name')
                            ->content(fn ($record,Get $get) => $record?->bank_name),
                        Forms\Components\Placeholder::make('bank_number')
                            ->content(fn ($record,Get $get) => $record?->bank_number),
                        Forms\Components\Placeholder::make('bank_iban')
                            ->content(fn ($record,Get $get) => $record?->bank_iban),
                        Forms\Components\Placeholder::make('commission')
                            ->content(fn ($record,Get $get) => $record?->commission),
                        Forms\Components\Placeholder::make('tracking_number')
                            ->content(fn ($record,Get $get) => $record?->tracking_number),
                        Forms\Components\Placeholder::make('created_at')
                            ->content(fn ($record,Get $get) => $record?->created_at),
                        Forms\Components\Placeholder::make('created_at')
                            ->content(fn ($record) => $record->created_at),
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
                                ->orderByDesc('number_works_approved')
                                ->get()
                                ->mapWithKeys(fn($item) => [
                                    $item->id => '#'. $item->id .' '. $item->customer_name .' - AW:'. $item->number_works_approved
                                ])
                            )
                            ->multiple()
                            ->preload(),
                        Forms\Components\FileUpload::make('picture')
                            ->image(),
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
                Tables\Columns\TextColumn::make('bank_name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tracking_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('commission')
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
            'view' => Pages\ViewCheckout::route('/{record}'),
        ];
    }
}
