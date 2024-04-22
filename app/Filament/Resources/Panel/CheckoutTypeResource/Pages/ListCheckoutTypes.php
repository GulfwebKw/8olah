<?php

namespace App\Filament\Resources\Panel\CheckoutTypeResource\Pages;

use App\Filament\Resources\Panel\CheckoutTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCheckoutTypes extends ListRecords
{
    protected static string $resource = CheckoutTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
