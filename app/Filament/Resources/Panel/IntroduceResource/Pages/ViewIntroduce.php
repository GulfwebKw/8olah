<?php

namespace App\Filament\Resources\Panel\IntroduceResource\Pages;

use App\Filament\Resources\Panel\IntroduceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\ViewRecord;

class ViewIntroduce extends ViewRecord
{
    protected static string $resource = IntroduceResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            IntroduceResource\Widgets\APIOverview::class
        ];
    }
}
