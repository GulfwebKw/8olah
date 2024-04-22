<?php

namespace App\Filament\Resources\Panel\CheckoutTypeResource\Pages;

use App\Filament\Resources\Panel\CheckoutTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCheckoutType extends EditRecord
{
    protected static string $resource = CheckoutTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
