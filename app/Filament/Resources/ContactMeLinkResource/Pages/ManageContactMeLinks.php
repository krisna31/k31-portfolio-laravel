<?php

namespace App\Filament\Resources\ContactMeLinkResource\Pages;

use App\Filament\Resources\ContactMeLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageContactMeLinks extends ManageRecords
{
    protected static string $resource = ContactMeLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
