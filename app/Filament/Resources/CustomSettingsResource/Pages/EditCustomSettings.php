<?php

namespace App\Filament\Resources\CustomSettingsResource\Pages;

use App\Filament\Resources\CustomSettingsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomSettings extends EditRecord
{
    protected static string $resource = CustomSettingsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
