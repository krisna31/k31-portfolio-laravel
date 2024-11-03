<?php

namespace App\Filament\Resources\AttendesHistoryResource\Pages;

use App\Filament\Resources\AttendesHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAttendesHistories extends ListRecords
{
    protected static string $resource = AttendesHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
