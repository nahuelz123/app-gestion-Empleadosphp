<?php

namespace App\Filament\Resources\TimeseetResource\Pages;

use App\Filament\Resources\TimeseetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTimeseet extends EditRecord
{
    protected static string $resource = TimeseetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
