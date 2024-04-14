<?php

namespace App\Filament\Resources\Panel\MarketerResource\Pages;

use App\Filament\Resources\Panel\MarketerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMarketer extends EditRecord
{
    protected static string $resource = MarketerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }


    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ( $data['password'] ) {
            $data['password'] = bcrypt($data['password']);
            unset($data['password_confirmation']);
        } else {
            unset($data['password_confirmation'],$data['password']);
        }
        $data['is_admin'] = false;
        return $data;
    }
}
