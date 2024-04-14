<?php

namespace App\Filament\Resources\Panel\IntroduceResource\Pages;

use App\Filament\Resources\Panel\IntroduceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIntroduces extends ListRecords
{
    protected static string $resource = IntroduceResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
