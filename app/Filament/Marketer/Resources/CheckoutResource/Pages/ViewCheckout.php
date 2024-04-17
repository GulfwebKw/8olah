<?php

namespace App\Filament\Marketer\Resources\CheckoutResource\Pages;

use App\Filament\Marketer\Resources\CheckoutResource;
use App\Models\Introduce;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCheckout extends ViewRecord
{
    protected static string $resource = CheckoutResource::class;


    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data = parent::mutateFormDataBeforeFill($data);
        $data['Introduces'] = Introduce::query()
            ->where('checkout_id' , $data['id'])
            ->pluck('id')
            ->toArray();
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
