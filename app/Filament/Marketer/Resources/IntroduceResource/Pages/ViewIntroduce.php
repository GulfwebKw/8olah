<?php

namespace App\Filament\Marketer\Resources\IntroduceResource\Pages;

use App\Filament\Marketer\Resources\IntroduceResource;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Builder;

class ViewIntroduce extends ViewRecord
{
    protected static string $resource = IntroduceResource::class;



    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function authorizeAccess(): void
    {
        abort_unless($this->getRecord()->user_id == Filament::auth()->id() , 403);
    }
}
