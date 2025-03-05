<?php

namespace App\Filament\Home\Resources\TimeseetResource\Pages;

use App\Filament\Home\Resources\TimeseetResource;
use App\Models\Timeseet;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListTimeseets extends ListRecords
{
    protected static string $resource = TimeseetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('inWork')
            ->label('Entrar al trabajo')
            ->color('success')
            ->requiresConfirmation()
            ->action(function(){
                $user = Auth::user();
                $timeseet =  new Timeseet();
                $timeseet->calendar_id = 1;
                $timeseet->user_id = $user->id;
                $timeseet->day_in =Carbon::now();
                $timeseet->day_out = Carbon::now();
                $timeseet->type = 'work';
                $timeseet->save();
            }),
            Action::make('inPause')
            ->label('Descanso')
            ->color('info')
            ->requiresConfirmation()
            
            ->action(function(){
                $user = Auth::user();
                $timeseet = new Timeseet();
                $timeseet->calendar_id = 1;
                $timeseet->user_id = $user->id;
                $timeseet->day_in = Carbon::now();
                $timeseet->day_out = Carbon::now();
                $timeseet->type = 'pause';
                $timeseet->save();
            }),
            Actions\CreateAction::make(),
        
        ];
    }
}
