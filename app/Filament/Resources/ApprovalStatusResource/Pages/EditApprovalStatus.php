<?php

namespace App\Filament\Resources\ApprovalStatusResource\Pages;

use App\Filament\Resources\ApprovalStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApprovalStatus extends EditRecord
{
    protected static string $resource = ApprovalStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
