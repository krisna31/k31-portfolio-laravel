<?php

namespace App\Filament\Resources\ApprovalStatusResource\Pages;

use App\Filament\Resources\ApprovalStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApprovalStatuses extends ListRecords
{
    protected static string $resource = ApprovalStatusResource::class;

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
