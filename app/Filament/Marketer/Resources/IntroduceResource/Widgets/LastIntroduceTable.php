<?php

namespace App\Filament\Marketer\Resources\IntroduceResource\Widgets;

use App\Filament\Marketer\Resources\IntroduceResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LastIntroduceTable extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(IntroduceResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
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
            ]);
    }
}
