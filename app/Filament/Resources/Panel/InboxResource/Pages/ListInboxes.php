<?php

namespace App\Filament\Resources\Panel\InboxResource\Pages;

use App\Filament\Resources\Panel\InboxResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInboxes extends ListRecords
{
    protected static string $resource = InboxResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
