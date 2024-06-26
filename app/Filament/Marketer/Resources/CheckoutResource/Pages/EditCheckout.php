<?php

namespace App\Filament\Marketer\Resources\CheckoutResource\Pages;

use App\Filament\Marketer\Resources\CheckoutResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCheckout extends EditRecord
{
    protected static string $resource = CheckoutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
