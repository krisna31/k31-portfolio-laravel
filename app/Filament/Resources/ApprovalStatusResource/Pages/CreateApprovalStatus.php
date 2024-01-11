<?php

namespace App\Filament\Resources\ApprovalStatusResource\Pages;

use App\Filament\Resources\ApprovalStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateApprovalStatus extends CreateRecord
{
    protected static string $resource = ApprovalStatusResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
