<?php

namespace App\Filament\Resources\Panel\CheckoutResource\Pages;

use App\Filament\Resources\Panel\CheckoutResource;
use App\Models\Introduce;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ViewRecord;

class viewCheckout extends vieWRecord
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
            Actions\EditAction::make(),
        ];
    }
}
