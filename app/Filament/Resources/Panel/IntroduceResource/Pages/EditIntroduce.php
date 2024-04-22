<?php

namespace App\Filament\Resources\Panel\IntroduceResource\Pages;

use App\Filament\Resources\Panel\IntroduceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIntroduce extends EditRecord
{
    protected static string $resource = IntroduceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            IntroduceResource\Widgets\APIOverview::class
        ];
    }
}
