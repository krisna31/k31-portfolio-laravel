<?php

namespace App\Filament\Resources\AttendesHistoryResource\Pages;

use App\Filament\Resources\AttendesHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewAttendesHistories extends ViewRecord
{
    protected static string $resource = AttendesHistoryResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('id'),
                Infolists\Components\TextEntry::make('user.name'),
                Infolists\Components\TextEntry::make('attendeCode.id'),
                Infolists\Components\TextEntry::make('approvalStatus.name'),
                Infolists\Components\TextEntry::make('attendeStatus.name'),
                Infolists\Components\TextEntry::make('attende_time'),
                Infolists\Components\TextEntry::make('address'),
                Infolists\Components\TextEntry::make('latitude'),
                Infolists\Components\TextEntry::make('longitude'),
                Infolists\Components\IconEntry::make(name: 'is_spoofing')
                    ->label('Wajah Palsu?')
                    ->icon(fn(string $state): string => match ($state) {
                        '1' => 'heroicon-o-check-circle',
                        default => 'heroicon-o-x-circle',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        '1' => 'danger',
                        default => 'success',
                    }),
                Infolists\Components\TextEntry::make('created_at'),
                Infolists\Components\TextEntry::make('updated_at'),
                Infolists\Components\ImageEntry::make('photo')
                    ->visibility('private')
                    ->size(800)
                    ->columnSpanFull(),
            ]);
    }
}
