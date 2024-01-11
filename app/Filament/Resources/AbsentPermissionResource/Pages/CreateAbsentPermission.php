<?php

namespace App\Filament\Resources\AbsentPermissionResource\Pages;

use App\Filament\Resources\AbsentPermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAbsentPermission extends CreateRecord
{
    protected static string $resource = AbsentPermissionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
