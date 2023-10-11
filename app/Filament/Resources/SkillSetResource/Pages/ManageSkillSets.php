<?php

namespace App\Filament\Resources\SkillSetResource\Pages;

use App\Filament\Resources\SkillSetResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSkillSets extends ManageRecords
{
    protected static string $resource = SkillSetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
