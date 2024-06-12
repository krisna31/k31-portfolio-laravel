<?php

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;

class Dashboard extends BaseDashboard
{
    use HasFiltersAction;

    protected function getHeading(): string
    {
        $company = auth()->user()->company->name;
        return "{$company}'s Dashboard";
    }

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         FilterAction::make()
    //             ->form([
    //                 DatePicker::make('startDate'),
    //                 DatePicker::make('endDate'),
    //                 // ...
    //             ]),
    //     ];
    // }
}
