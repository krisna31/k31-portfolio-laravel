<?php

namespace App\Filament\Resources\AttendeStatusResource\Pages;

use App\Filament\Resources\AttendeStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAttendeStatuses extends ListRecords
{
    protected static string $resource = AttendeStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
