<?php

namespace App\Filament\Pages;

use Filament\Notifications\Notification;
use Artisan;
use Log;

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
                    try {
                        // start the backup process
                        Artisan::call('backup:run', ['--only-db' => 'true']);
                        $output = Artisan::output();
                        // log the results
                        Log::info("Backpack\BackupManager -- new backup started from admin interface \r\n" . $output);
                        return Notification::make()
                            ->title('Backup successfully')
                            ->success()
                            ->send();
                    } catch (Exception $e) {
                        // log the error
                        Log::error("Backpack\BackupManager -- new backup failed from admin interface \r\n" . $e->getMessage());
                        return Notification::make()
                            ->title('Backup failed')
                            ->body($e->getMessage())
                            ->error()
                            ->send();
                    }
                })
                ->icon('heroicon-o-circle-stack')
                ->color('info')
                ->label('Backup Database'),
        ];
    }
}
