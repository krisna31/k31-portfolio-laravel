<?php

namespace App\Filament\App\Resources\AttendeCodeResource\Pages;

use App\Filament\App\Resources\AttendeCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAttendeCodes extends ListRecords
{
    protected static string $resource = AttendeCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
