<?php

namespace App\Filament\Pages;


class Dashboard extends \Filament\Pages\Dashboard {
    public function getHeading(): string {
        return "PT Anugerah Alam Konstruksi - Dashboard";
    }

    public function getHeaderActions(): array {
        return [
            \Filament\Actions\Action::make('Backup Database')
                ->button()
                ->requiresConfirmation()
                ->action(function() {
                    dd('Backup Database');
                    \Artisan::call('backup:run');
                })
                ->icon('heroicon-o-circle-stack')
                ->color('info')
                ->label('Backup Database'),
        ];
    }
}
