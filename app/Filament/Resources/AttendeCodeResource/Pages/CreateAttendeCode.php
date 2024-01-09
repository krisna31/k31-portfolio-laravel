<?php

namespace App\Filament\Resources\AttendeCodeResource\Pages;

use App\Filament\Resources\AttendeCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateAttendeCode extends CreateRecord
{
    protected static string $resource = AttendeCodeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // generate code
        $data['code'] = str()->random(32);

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        return static::getModel()::create($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
