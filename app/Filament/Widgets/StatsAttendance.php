<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class StatsAttendance extends BaseWidget
{
    // protected static ?int $navigationSort = 2;

    protected function getStats(): array
      {
        // Total Day
        $startOfDay = Carbon::now()->startOfDay();
        $endOfDay = Carbon::now()->endOfDay();
        $attendanceCountDay = Attendance::whereBetween('date_attendance', [$startOfDay, $endOfDay])->count();
        $hoy = Carbon::now();

        // Total Week
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $attendanceCountWeek = Attendance::whereBetween('date_attendance', [$startOfWeek, $endOfWeek])->count();

        // Total Month
        $firstDayOfMonth = Carbon::now()->startOfMonth();
        $lastDayOfMonth = Carbon::now()->endOfMonth();
        $attendanceCount = Attendance::whereBetween('date_attendance', [$firstDayOfMonth, $lastDayOfMonth])->count();
        
        // Last Month
        $firstDayOfLastMonth = Carbon::now()->subMonthNoOverflow()->startOfMonth();
        $lastDayOfLastMonth = Carbon::now()->subMonthNoOverflow()->endOfMonth();
        $attendanceMonthLast = Attendance::whereBetween('date_attendance', [$firstDayOfLastMonth, $lastDayOfLastMonth])->count();

        
        return [
            Stat::make('Total de asistencias hoy', $attendanceCountDay)
                ->description('Asistencias hoy, '. $hoy->isoFormat('dddd DD \d\e MMMM'))
                ->descriptionIcon('heroicon-o-user-plus', IconPosition::Before)
                ->color('success')
                ->chart([1, 5, 10, 30, 80, 100, 250, 350]),
            
            Stat::make('Total de asistencias esta semana', $attendanceCountWeek)
                ->description('Asistencias de esta semana de '. $hoy->isoFormat('MMMM'))
                ->descriptionIcon('heroicon-o-calendar', IconPosition::Before)
                ->color('warning')
                ->chart([100, 280, 750, 2300, 4350, 8500]),

            Stat::make('Total de asistencias este mes', $attendanceCount)
                ->description('Asistencias del mes anterior: '." $attendanceMonthLast")
                ->descriptionIcon('heroicon-o-calendar-days', IconPosition::Before)
                // ->description('Asistencias del mes anterior ', )
                ->color('info')
                ->chart([100, 280, 750, 2300, 4350, 8500])
                ->extraAttributes([
                  // 'label' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
                  'label' => $attendanceMonthLast,
              ]),
        ];
    }
}