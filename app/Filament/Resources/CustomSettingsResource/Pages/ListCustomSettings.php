<?php

namespace App\Filament\Resources\CustomSettingsResource\Pages;

use App\Filament\Resources\CustomSettingsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomSettings extends ListRecords
{
    protected static string $resource = CustomSettingsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
