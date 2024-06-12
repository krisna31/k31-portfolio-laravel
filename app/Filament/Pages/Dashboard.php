<?php

namespace App\Filament\Pages;


class Dashboard extends \Filament\Pages\Dashboard {
    public function getHeading(): string {
        return "PT Anugerah Alam Konstruksi - Dashboard";
    }

    public function getHeaderActions(): array {
        return [
            \Tables\Actions\Action::make('Backup Database')
                ->button()
                ->icon('heroicon-o-information-circle')
                ->color('info')
                ->label('Backup Database'),
        ];
    }
}
