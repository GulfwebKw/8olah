<?php

namespace App\Filament\Marketer\Widgets;

use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {


        $earnedJobs = \App\Models\Introduce::query()
                ->where('user_id' , Filament::auth()->id())
                ->where('is_earned' , true)
                ->sum('number_works_approved');
        $unpaidJobs = \App\Models\Introduce::query()
                ->where('user_id' , Filament::auth()->id())
                ->where('is_earned' , false)
                ->sum('number_works_approved');
        $totalJobs = \App\Models\Introduce::query()
                ->where('user_id' , Filament::auth()->id())
                ->sum('number_works_approved');

        return [
            Stat::make(__('Total Job'), Number::format($totalJobs * Filament::auth()->user()->commission_per_work) . ' ' . __('KD'))
                ->description(Number::format($totalJobs)  . ' ' . __('Job') )
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make(__('Total Paid Job'), Number::format($earnedJobs * Filament::auth()->user()->commission_per_work) . ' ' . __('KD'))
                ->description(Number::format($earnedJobs)  . ' ' . __('Job') )
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make(__('Total Unpaid Job'), Number::format($unpaidJobs * Filament::auth()->user()->commission_per_work) . ' ' . __('KD'))
                ->description(Number::format($unpaidJobs)  . ' ' . __('Job') )
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}
