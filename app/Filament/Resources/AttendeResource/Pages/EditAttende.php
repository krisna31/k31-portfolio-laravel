<?php

namespace App\Filament\Resources\AttendeResource\Pages;

use App\Filament\Resources\AttendeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttende extends EditRecord {
    protected static string $resource = AttendeResource::class;

    protected function getHeaderActions(): array {
        return [
            // Actions\DeleteAction::make(),
            Actions\RestoreAction::make(),
            \Tables\Actions\Action::make('Reset')
                ->visible(fn (Attende $record): bool => $record->attende_time != null && $record->attende_status_id != null && $record->approval_status_id != null && $record->approval_status_id == 2)
                ->slideOver()
                ->requiresConfirmation()
                ->modalWidth(\Filament\Support\Enums\MaxWidth::Medium)
                ->action(function (Attende $record): void {
                    $record->update([
                        'attende_time' => null,
                        'attende_status_id' => null,
                        'approval_status_id' => 1,
                    ]);
                })
                ->modalSubmitActionLabel('Ya, Reset')
                ->color('warning')
                ->icon('heroicon-o-refresh'),
        ];
    }

    protected function getRedirectUrl(): string {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
