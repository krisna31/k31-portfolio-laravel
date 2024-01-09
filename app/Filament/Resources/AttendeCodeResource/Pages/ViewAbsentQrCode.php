<?php

namespace App\Filament\Resources\AttendeCodeResource\Pages;

use App\Filament\Resources\AttendeCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAbsentQrCode extends ViewRecord
{
    protected static string $resource = AttendeCodeResource::class;

    protected static string $view = 'filament.resources.users.pages.view-user';
}
