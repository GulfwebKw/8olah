<?php

namespace App\Filament\Marketer\Resources\IntroduceResource\Widgets;

use App\Filament\Marketer\Resources\IntroduceResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class LastIntroduceTable extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;



    /**
     * @return string|null
     */

    public function getTableHeading(): ?string
    {
        return __('Last Introduce Table');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(IntroduceResource::getEloquentQuery())
            ->modelLabel(__('Last Introduce Table'))
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label(__('filament-actions::view.single.label'))
                    ->url(fn(Model $record): string => IntroduceResource::getUrl('view' , [$record]))
                    ->icon('heroicon-o-eye'),
            ])
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
