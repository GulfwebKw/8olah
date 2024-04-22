<?php

namespace App\Filament\Resources\Panel\IntroduceResource\Widgets;

use App\Filament\Resources\Panel\IntroduceResource;
use App\Models\Introduce;
use App\Models\IntroduceApi;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;
class APIOverview extends BaseWidget
{
    public ?Model $record = null;
    protected int | string | array $columnSpan = 'full';

    public static ?string $customer_phone = null;

    public function getTableHeading(): ?string
    {
        return 'System Orders';
    }

    public function table(Table $table): Table
    {
        self::$customer_phone = $this->record?->customer_phone;
        return $table
            ->query(IntroduceApi::query())
            ->columns([
                Tables\Columns\TextColumn::make('total_jobs')
                    ->label('Number Works')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created')
                    ->label('Created At')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
            ])->defaultSort('created','desc');
    }
}
