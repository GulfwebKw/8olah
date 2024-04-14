<?php

namespace App\Filament\Resources\Panel\MarketerResource\Pages;

use App\Filament\Resources\Panel\MarketerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMarketer extends CreateRecord
{
    protected static string $resource = MarketerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['is_admin'] = false;
        return $data;
    }
}
