<?php

namespace App\Filament\Resources\GenderResource\Pages;

use App\Filament\Resources\GenderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGender extends CreateRecord
{
    protected static string $resource = GenderResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
