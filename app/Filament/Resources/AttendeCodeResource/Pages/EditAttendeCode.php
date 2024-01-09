<?php

namespace App\Filament\Resources\AttendeCodeResource\Pages;

use App\Filament\Resources\AttendeCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttendeCode extends EditRecord
{
    protected static string $resource = AttendeCodeResource::class;

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
