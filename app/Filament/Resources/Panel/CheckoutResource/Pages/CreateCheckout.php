<?php

namespace App\Filament\Resources\Panel\CheckoutResource\Pages;

use App\Filament\Resources\Panel\CheckoutResource;
use App\Models\Introduce;
use App\Models\User;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreateCheckout extends CreateRecord
{
    protected static string $resource = CheckoutResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user =  User::query()->find($data['user_id']);
        $data['admin_id'] = Filament::auth()->id();
        $data['bank_name'] = $user?->bank_name;
        $data['bank_number'] = $user?->bank_number;
        $data['bank_iban'] = $user?->bank_iban;
        return $data;
    }
    protected function afterCreate(){
        Introduce::query()
            ->whereIn('id' , optional($this->form->getRawState())['Introduces'] ?? [] )
            ->update([
                'is_earned' => true,
                'checkout_id' => $this->record?->id
            ]);
    }
}
