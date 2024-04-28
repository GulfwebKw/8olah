<?php

namespace App\Filament\Resources\Panel\InboxResource\Pages;

use App\Filament\Resources\Panel\CheckoutResource\Pages\CreateCheckout;
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
            Actions\Action::make('create_checkOut')
                ->label('Make Check Out')
                ->url(CreateCheckout::getUrl(['request_id' => $this->record?->id]))
        ];
    }

    public function mount(int | string $record): void
    {
        parent::mount($record);
        $this->record->seen = true;
        $this->record->save();
    }
}
