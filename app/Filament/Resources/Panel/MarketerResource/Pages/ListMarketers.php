<?php

namespace App\Filament\Resources\Panel\MarketerResource\Pages;

use App\Filament\Resources\Panel\MarketerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListMarketers extends ListRecords
{
    protected static string $resource = MarketerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): ?Builder
    {
        return parent::getTableQuery()->where('is_admin' , false);
    }
}
