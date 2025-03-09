<?php

namespace App\Filament\Home\Resources\HolidayResource\Pages;

use App\Filament\Home\Resources\HolidayResource;
use App\Mail\HolidayPending;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CreateHoliday extends CreateRecord
{
    protected static string $resource = HolidayResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        $data['type'] = 'pending';

        $userAdmin = User::find(1);
        $dataToSend = array(
          'day'=>$data['day'],
          'name'=>User::find($data['user_id'])->name,
          'email'=>User::find($data['user_id'])->email,   
        );
        Mail::to($userAdmin)->send(new HolidayPending($data));
        Notification::make()
            ->title('Holiday request sent')
            ->success()
            ->send();

$recipient = auth()->user();
Notification::make()
->title('Solicitud de vacaciones ')
->body('El dia '.$data['day'].' ha solicitado vacaciones')
->sendToDatabase($recipient);
        return $data;
    }
}
