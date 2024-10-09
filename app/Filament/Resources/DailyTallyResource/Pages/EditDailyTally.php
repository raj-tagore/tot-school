<?php

namespace App\Filament\Resources\DailyTallyResource\Pages;

use App\Filament\Resources\DailyTallyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDailyTally extends EditRecord
{
    protected static string $resource = DailyTallyResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
