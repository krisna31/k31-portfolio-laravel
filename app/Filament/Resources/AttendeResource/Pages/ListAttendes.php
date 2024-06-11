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
                ->modifyQueryUsing(function ($query) {
                    return $query;
                }),
            'Hari Ini' => \Filament\Resources\Components\Tab::make('Hari Ini')
                ->modifyQueryUsing(function ($query) {
                    return $query->whereDate('created_at', now());
                }),
            'Minggu Ini' => \Filament\Resources\Components\Tab::make('Minggu Ini')
                ->modifyQueryUsing(function ($query) {
                    return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                }),
            'Bulan Ini' => \Filament\Resources\Components\Tab::make('Bulan Ini')
                ->modifyQueryUsing(function ($query) {
                    return $query->whereMonth('created_at', now()->month);
                }),
        ];
    }
}
