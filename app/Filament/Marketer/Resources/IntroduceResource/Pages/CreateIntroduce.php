<?php

namespace App\Filament\Marketer\Resources\IntroduceResource\Pages;

use App\Filament\Marketer\Resources\IntroduceResource;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreateIntroduce extends CreateRecord
{
    protected static string $resource = IntroduceResource::class;


    /**
     * @return string|null
     */
    public function getHeading(): \Illuminate\Contracts\Support\Htmlable|string
    {
        return __('New Introduce');
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Filament::auth()->id();
        return $data;
    }
}
