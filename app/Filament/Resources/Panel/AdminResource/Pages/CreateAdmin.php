<?php

namespace App\Filament\Resources\Panel\AdminResource\Pages;

use App\Filament\Resources\Panel\AdminResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['is_admin'] = true;
        return $data;
    }
}
