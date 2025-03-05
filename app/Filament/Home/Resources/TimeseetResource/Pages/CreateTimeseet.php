<?php

namespace App\Filament\Home\Resources\TimeseetResource\Pages;

use App\Filament\Home\Resources\TimeseetResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateTimeseet extends CreateRecord
{
    protected static string $resource = TimeseetResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        return $data;
    }
}
