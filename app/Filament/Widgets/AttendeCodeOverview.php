<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AttendeCodeOverview extends BaseWidget
{
    protected int|string|array $columnSpan = 12;
    protected function getStats(): array
    {
        $attendecode = \App\Models\AttendeCode::all();
        $codeLastWeek = \App\Models\AttendeCode::query()
            ->whereBetween('created_at', [now()->subWeek(), now()])
            ->get()
            ->count();

        $user = \App\Models\User::count();
        $userLastWeek = \App\Models\User::query()
            ->whereBetween('created_at', [now()->subWeek(), now()])
            ->get()
            ->count();

        // $attendes = \App\Models\Attende::count();
        // $attendesLastWeek = \App\Models\Attende::query()
        //     ->whereBetween('created_at', [now()->subWeek(), now()])
        //     ->get()
        //     ->count();
        return [
            Stat::make('Total Kode Presensi', $attendecode->count())
                ->description("$codeLastWeek kode presensi dibuat semimggu terakhir")
                ->descriptionIcon('heroicon-m-chart-bar-square')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Total Pegawai', $user)
                ->description($userLastWeek . " Pegawai terdaftar seminggu terakhir")
                ->descriptionIcon('heroicon-m-user-circle')
                ->chart([3, 12, 5, 8, 2, 10, 3])
                ->color('secondary'),
            // Stat::make('Total Presensi Pegawai', $attendes)
            //     ->description($attendesLastWeek . " presensi Pegawai")
            //     ->descriptionIcon('heroicon-m-clock')
            //     ->chart([10, 3, 15, 4, 17, 2, 10])
            //     ->color('warning'),
        ];
    }
}
