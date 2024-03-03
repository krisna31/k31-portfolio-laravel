<?php

namespace App\Filament\Widgets;

use App\Models\Attende;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AttendesChart extends ChartWidget
{
    protected static ?string $heading = 'Total Absensi Karyawan';

    public ?string $filter = 'month';

    protected int|string|array $columnSpan = 'full';

    protected function getData(
    ): array {
        $filter = $this->filter;
        $data = Trend::model(Attende::class);

        if ($filter === 'month') {
            $data = $data->between(
                start: now()->startOfMonth(),
                end: now()->endOfMonth(),
            )
                ->perDay()
                ->count();
        } else if ($filter === 'year') {
            $data = $data->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
                ->perMonth()
                ->count();
        }

        return [
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
            'datasets' => [
                [
                    'label' => 'Total Absensi Karyawan',
                    'backgroundColor' => '#f87979',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getFilters(): ?array
    {
        return [
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }
}
