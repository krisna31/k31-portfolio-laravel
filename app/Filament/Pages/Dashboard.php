<?php

namespace App\Filament\Pages;

use Alert;
use Artisan;
use Log;
use Spatie\Backup\Helpers\Format;
use Storage;

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
                        return Alert::success('Backup Database Successful', 'The database has been successfully backed up.');
                    } catch (Exception $e) {
                        // log the error
                        Log::error("Backpack\BackupManager -- new backup failed from admin interface \r\n" . $e->getMessage());
                        return Alert::error('Backup Database Failed', 'An error occurred while trying to backup the database. Please check the logs for more information.');
                    }
                })
                ->icon('heroicon-o-circle-stack')
                ->color('info')
                ->label('Backup Database'),
        ];
    }
}
