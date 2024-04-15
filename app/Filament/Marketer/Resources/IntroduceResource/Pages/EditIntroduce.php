<?php

namespace App\Filament\Marketer\Resources\IntroduceResource\Pages;

use App\Filament\Marketer\Resources\IntroduceResource;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\EditRecord;

class EditIntroduce extends EditRecord
{
    protected static string $resource = IntroduceResource::class;


    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = Filament::auth()->id();
        return $data;
    }

    protected function authorizeAccess(): void
    {
        abort_unless($this->getRecord()->user_id == Filament::auth()->id() , 403);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
        ];
    }
}
