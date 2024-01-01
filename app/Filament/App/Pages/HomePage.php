<?php

namespace App\Filament\App\Pages;

use Filament\Pages\Page;

class HomePage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.app.pages.home-page';
}
