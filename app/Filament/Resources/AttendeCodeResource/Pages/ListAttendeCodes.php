<?php

namespace App\Filament\Resources\AttendeCodeResource\Pages;

use App\Filament\Resources\AttendeCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAttendeCodes extends ListRecords
{
    protected static string $resource = AttendeCodeResource::class;

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
