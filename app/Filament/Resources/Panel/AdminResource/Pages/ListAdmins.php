<?php

namespace App\Filament\Resources\Panel\AdminResource\Pages;

use App\Filament\Resources\Panel\AdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListAdmins extends ListRecords
{
    protected static string $resource = AdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): ?Builder
    {
        return parent::getTableQuery()->where('is_admin' , true);
    }
}
