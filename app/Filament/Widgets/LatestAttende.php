<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestAttende extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                \App\Models\Attende::query()
                    ->latest()
                    ->limit(10)
            )
            ->columns(\App\Filament\Resources\AttendeResource::table($table)->getColumns());
    }
}
