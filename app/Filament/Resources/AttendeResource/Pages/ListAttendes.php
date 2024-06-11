<?php

namespace App\Filament\Resources\AttendeResource\Pages;

use App\Filament\Resources\AttendeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAttendes extends ListRecords {
    protected static string $resource = AttendeResource::class;

    protected function getHeaderActions(): array {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getRedirectUrl(): string {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    public function getTabs(): array {
        return [
            'Semua' => \Filament\Resources\Components\Tab::make('Semua')
                ->badge(function () {
                    return \App\Models\Attende::count();
                })
                ->modifyQueryUsing(function ($query) {
                    return $query;
                }),
            'Hari Ini' => \Filament\Resources\Components\Tab::make('Hari Ini')
                ->badge(function () {
                    return \App\Models\Attende::whereDate('created_at', now())
                        ->orWhereDate('updated_at', now())
                        ->orWhereDate('attende_time', now())
                        ->count();
                })
                ->modifyQueryUsing(function ($query) {
                    return $query->where(function ($q) {
                        $q->whereDate('created_at', now())
                            ->orWhereDate('updated_at', now())
                            ->orWhereDate('attende_time', now());
                    });
                }),
            'Minggu Ini' => \Filament\Resources\Components\Tab::make('Minggu Ini')
                ->badge(function () {
                    return \App\Models\Attende::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                        ->orWhereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()])
                        ->orWhereBetween('attende_time', [now()->startOfWeek(), now()->endOfWeek()])
                        ->count();
                })
                ->modifyQueryUsing(function ($query) {
                    return $query->where(function ($q) {
                        $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                            ->orWhereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()])
                            ->orWhereBetween('attende_time', [now()->startOfWeek(), now()->endOfWeek()]);
                    });
                }),
            'Bulan Ini' => \Filament\Resources\Components\Tab::make('Bulan Ini')
                ->badge(function () {
                    return \App\Models\Attende::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                        ->orWhereBetween('updated_at', [now()->startOfMonth(), now()->endOfMonth()])
                        ->orWhereBetween('attende_time', [now()->startOfMonth(), now()->endOfMonth()])
                        ->count();
                })
                ->modifyQueryUsing(function ($query) {
                    return $query->where(function ($q) {
                        $q->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                            ->orWhereBetween('updated_at', [now()->startOfMonth(), now()->endOfMonth()])
                            ->orWhereBetween('attende_time', [now()->startOfMonth(), now()->endOfMonth()]);
                    });
                }),
            'Menunggu Persetujuan' => \Filament\Resources\Components\Tab::make('Menunggu Persetujuan')
                ->badge(function () {
                    return \App\Models\Attende::where('approval_status_id', '1')->count();
                })
                ->badgeColor('warning')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('approval_status_id', '1');
                }),
            'Disetujui' => \Filament\Resources\Components\Tab::make('Disetujui')
                ->badge(function () {
                    return \App\Models\Attende::where('approval_status_id', '2')->count();
                })
                ->badgeColor('success')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('approval_status_id', '2');
                }),
            'Ditolak' => \Filament\Resources\Components\Tab::make('Ditolak')
                ->badge(function () {
                    return \App\Models\Attende::where('approval_status_id', '3')->count();
                })
                ->badgeColor('danger')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('approval_status_id', '3');
                }),
        ];
    }
}
