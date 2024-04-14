<?php

namespace App\Filament\Resources\Panel\AdminResource\Pages;

use App\Filament\Resources\Panel\AdminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;


    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ( $data['password'] ) {
            $data['password'] = bcrypt($data['password']);
            unset($data['password_confirmation']);
        } else {
            unset($data['password_confirmation'],$data['password']);
        }
        $data['is_admin'] = true;
        return $data;
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
