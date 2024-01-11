<?php

namespace App\Filament\Resources\AttendeTypeResource\Pages;

use App\Filament\Resources\AttendeTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendeType extends CreateRecord
{
    protected static string $resource = AttendeTypeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
