<?php

namespace App\Filament\Resources\AbsentPermissionResource\Pages;

use App\Filament\Resources\AbsentPermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAbsentPermission extends EditRecord
{
    protected static string $resource = AbsentPermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
