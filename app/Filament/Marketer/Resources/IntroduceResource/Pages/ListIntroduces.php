<?php

namespace App\Filament\Marketer\Resources\IntroduceResource\Pages;

use App\Filament\Marketer\Resources\IntroduceResource;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListIntroduces extends ListRecords
{
    protected static string $resource = IntroduceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('New Introduce')),
        ];
    }
    protected function getTableQuery(): ?Builder
    {
        return parent::getTableQuery()->where('user_id' , Filament::auth()->id());
    }
}
