<?php

namespace App\Filament\Resources\Panel\MarketerResource\Pages;

use App\Filament\Resources\Panel\MarketerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ViewRecord;

class ViewMarketers extends ViewRecord
{
    protected static string $resource = MarketerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
