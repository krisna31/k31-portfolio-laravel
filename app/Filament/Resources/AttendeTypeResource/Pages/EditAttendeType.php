<?php

namespace App\Filament\Resources\AttendeTypeResource\Pages;

use App\Filament\Resources\AttendeTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttendeType extends EditRecord
{
    protected static string $resource = AttendeTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
