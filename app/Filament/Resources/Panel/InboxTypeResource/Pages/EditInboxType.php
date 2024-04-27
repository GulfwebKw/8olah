<?php

namespace App\Filament\Resources\Panel\InboxTypeResource\Pages;

use App\Filament\Resources\Panel\InboxTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInboxType extends EditRecord
{
    protected static string $resource = InboxTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
