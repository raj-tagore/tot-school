<?php

namespace App\Filament\Resources\DailyTallyResource\Pages;

use App\Filament\Resources\DailyTallyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDailyTallies extends ListRecords
{
    protected static string $resource = DailyTallyResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
