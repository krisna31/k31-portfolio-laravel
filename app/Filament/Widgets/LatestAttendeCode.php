<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestAttendeCode extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                \App\Models\AttendeCode::query()
                    ->latest()
                    ->limit(5)
            )
            ->columns(\App\Filament\Resources\AttendeCodeResource::table($table)->getColumns());
    }
}
