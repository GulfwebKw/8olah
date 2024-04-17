<?php

namespace App\Filament\Resources\Panel\CheckoutResource\Pages;

use App\Filament\Resources\Panel\CheckoutResource;
use App\Models\Introduce;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCheckout extends EditRecord
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


    protected function afterSave()
    {
        Introduce::query()
            ->where('checkout_id', $this->record?->id)
            ->where('is_earned', true)
            ->update([
                'is_earned' => false,
                'checkout_id' => null
            ]);
        Introduce::query()
            ->whereIn('id', optional($this->form->getRawState())['Introduces'] ?? [])
            ->update([
                'is_earned' => true,
                'checkout_id' => $this->record?->id
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
