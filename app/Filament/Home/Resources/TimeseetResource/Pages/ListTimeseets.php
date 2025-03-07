<?php

namespace App\Filament\Home\Resources\TimeseetResource\Pages;

use App\Filament\Home\Resources\TimeseetResource;
use App\Models\Timeseet;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ListTimeseets extends ListRecords
{
    protected static string $resource = TimeseetResource::class;

    protected function getHeaderActions(): array
    {
        $lastTimeseet = Timeseet::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();
        if ($lastTimeseet == null) {
            return [
                Action::make('inWork')
                    ->label('Entrar al trabajo')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function () {
                        $user = Auth::user();
                        $timeseet =  new Timeseet();
                        $timeseet->calendar_id = 1;
                        $timeseet->user_id = $user->id;
                        $timeseet->day_in = Carbon::now();
                        $timeseet->type = 'work';
                        $timeseet->save();
                        Notification::make()
                        ->title('Entrada al trabajo')
                        ->color('success')
                        ->success()
                        ->send();
                    }), 
                Actions\CreateAction::make(),
            ];
        }

        return [
            Action::make('inWork')
                ->label('Entrar al trabajo')
                ->color('success')
                ->visible(!$lastTimeseet->day_out == null)
                ->disabled($lastTimeseet->day_out == null)
                ->requiresConfirmation()
                ->action(function () {
                    $user = Auth::user();
                    $timeseet =  new Timeseet();
                    $timeseet->calendar_id = 1;
                    $timeseet->user_id = $user->id;
                    $timeseet->day_in = Carbon::now();
                    $timeseet->type = 'work';
                    $timeseet->save();
                    Notification::make()
                    ->title('Entrada al trabajo')
                    ->color('success')
                    ->success()
                    ->send();
                }),
            Action::make('stopWork')
                ->label('Parar de trabajar')
                ->color('success')
                ->requiresConfirmation()
                ->visible($lastTimeseet->day_out == null && $lastTimeseet->type != 'pause')
                ->disabled(!$lastTimeseet->day_out == null)
                ->action(function () use ($lastTimeseet) {
                    $lastTimeseet->day_out = Carbon::now();
                    $lastTimeseet->save();
                    Notification::make()
                    ->title('Salida del trabajo')
                    ->color('success')
                    ->success()
                    ->send();
                }),
            Action::make('inPause')
                ->label('Descanso')
                ->color('info')
                ->requiresConfirmation()
                ->visible($lastTimeseet->day_out == null && $lastTimeseet->type != 'pause')
                ->disabled(!$lastTimeseet->day_out == null)
                ->action(function () use ($lastTimeseet) {
                    $lastTimeseet->day_out = Carbon::now();
                    $lastTimeseet->save();
                    $timeseet = new Timeseet();
                    $timeseet->calendar_id = 1;
                    $timeseet->user_id = Auth::user()->id;
                    $timeseet->day_in = Carbon::now();
                    $timeseet->type = 'pause';
                    $timeseet->save();
                    Notification::make()
                    ->title('Comenzo el descanso')
                    ->color('info')
                    ->info()
                    ->send();
                }),

            Action::make('stopPause')
                ->label('Parar descanso')
                ->color('info')
                ->visible($lastTimeseet->day_out == null && $lastTimeseet->type == 'pause')
                ->disabled(!$lastTimeseet->day_out == null)
                ->requiresConfirmation()
                ->action(function () use ($lastTimeseet) {
                    $lastTimeseet->day_out = Carbon::now();
                    $lastTimeseet->save();
                    $timeseet = new Timeseet();
                    $timeseet->calendar_id = 1;
                    $timeseet->user_id = Auth::user()->id;
                    $timeseet->day_in = Carbon::now();
                    $timeseet->type = 'work';
                    $timeseet->save();
                    Notification::make()
                    ->title('Termino el descanso')
                    ->color('info')
                    ->info()
                    ->send();
                }),
            Actions\CreateAction::make(),

        ];
    }
}
