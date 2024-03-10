<?php

namespace App\Filament\Resources\PositionTypeResource\Pages;

use App\Filament\Resources\PositionTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePositionTypes extends ManageRecords
{
    protected static string $resource = PositionTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
