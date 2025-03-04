<?php

namespace App\Filament\Resources\TimeseetResource\Pages;

use App\Filament\Resources\TimeseetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTimeseets extends ListRecords
{
    protected static string $resource = TimeseetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
