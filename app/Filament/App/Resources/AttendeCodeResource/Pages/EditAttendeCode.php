<?php

namespace App\Filament\App\Resources\AttendeCodeResource\Pages;

use App\Filament\App\Resources\AttendeCodeResource;
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
}
