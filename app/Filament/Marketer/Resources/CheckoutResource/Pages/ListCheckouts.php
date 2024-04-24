<?php

namespace App\Filament\Marketer\Resources\CheckoutResource\Pages;

use App\Filament\Marketer\Resources\CheckoutResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCheckouts extends ListRecords
{
    protected static string $resource = CheckoutResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
