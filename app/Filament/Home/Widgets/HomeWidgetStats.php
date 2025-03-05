<?php

namespace App\Filament\Home\Widgets;

use App\Models\Holiday;
use App\Models\Timeseet;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class HomeWidgetStats extends BaseWidget
{
    protected function getStats(): array
    {

        return [
            Stat::make('Pending Holidays', $this->getPendingHolidays(Auth::user())),
            Stat::make('Approved Holidays', $this->getApprovedHolidays(Auth::user())),
            Stat::make('Total Work', $this->getTotalWork(Auth::user())),
        ];
    }

    protected function getPendingHolidays(User $user)
    {
        $totalPendingHolidays = Holiday::where('user_id', $user->id)->where('type', 'pending')->get()->count();
        return $totalPendingHolidays;
    }
    protected function getApprovedHolidays(User $user)
    {
        $getApprovedHolidays = Holiday::where('user_id', $user->id)->where('type', 'approved')->get()->count();
        return $getApprovedHolidays;
    }


    protected function getTotalWork(User $user)
    {
        $timeseets = Timeseet::where('user_id', $user->id)->where('type', 'work')->get();
        $sumSecons = 0;
        foreach ($timeseets as $timeseet) {
            $startTime = Carbon::parse($timeseet->day_in);
            $finishTime = Carbon::parse($timeseet->day_out); 
              
            $totalDuration = $finishTime->diffInSeconds($startTime);
            $sumSecons += $totalDuration;
        }
        $tiempoFormato = gmdate('H:i:s', $sumSecons);
        return $tiempoFormato;
    }

}
