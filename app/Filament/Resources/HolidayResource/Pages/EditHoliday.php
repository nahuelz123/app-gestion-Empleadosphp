<?php

namespace App\Filament\Resources\HolidayResource\Pages;

use App\Filament\Resources\HolidayResource;
use App\Mail\HolidayApproved;
use App\Mail\HolidayDecline;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class EditHoliday extends EditRecord
{
    protected static string $resource = HolidayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);
        if ($record->type == 'approved') {
            $user = User::find($record->user_id);
            $data = array(
                'day' => $record->day,
                'name' => $user->name,
                'email' => $user->email,
            );
//Mail::to($user)->send(new HolidayApproved($data));
            $recipient = auth()->user();
Notification::make()
->title('Solicitud de aprobada ')
->body('El dia '.$data['day'].' ha solicitado aprobado')
->sendToDatabase($recipient);
        } else if ($record->type == 'decline') {
            $userAdmin = User::find(1);
            $data = array(
                'day' => $record->day,
                'name' => User::find($record->user_id)->name,
                'email' => User::find($record->user_id)->email,
            );
           // Mail::to($userAdmin)->send(new HolidayDecline($data));
            $recipient = auth()->user();
            Notification::make()
            ->title('Solicitud de desaprobada ')
            ->body('El dia '.$data['day'].' ha solicitado desaprobado')
            ->sendToDatabase($recipient);
        }

        return $record;
    }
}
