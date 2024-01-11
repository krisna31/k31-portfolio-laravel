<?php

namespace App\Filament\Resources\AbsentPermissionResource\Pages;

use App\Filament\Resources\AbsentPermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAbsentPermissions extends ListRecords
{
    protected static string $resource = AbsentPermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
