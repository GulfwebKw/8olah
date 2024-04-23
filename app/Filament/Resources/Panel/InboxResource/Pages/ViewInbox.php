<?php

namespace App\Filament\Resources\Panel\InboxResource\Pages;

use App\Filament\Resources\Panel\InboxResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewInbox extends ViewRecord
{
    protected static string $resource = InboxResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\EditAction::make(),
        ];
    }

    public function mount(int | string $record): void
    {
        parent::mount($record);
        $this->record->seen = true;
        $this->record->save();
    }
}
