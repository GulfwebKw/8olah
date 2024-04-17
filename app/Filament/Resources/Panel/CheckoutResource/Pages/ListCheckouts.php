<?php

namespace App\Filament\Resources\Panel\CheckoutResource\Pages;

use App\Filament\Resources\Panel\CheckoutResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCheckouts extends ListRecords
{
    protected static string $resource = CheckoutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
