<?php

namespace App\Filament\Resources\CustomSettingsResource\Pages;

use App\Filament\Resources\CustomSettingsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomSettings extends CreateRecord
{
    protected static string $resource = CustomSettingsResource::class;
}
