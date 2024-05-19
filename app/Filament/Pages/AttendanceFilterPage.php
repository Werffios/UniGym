<?php

namespace App\Filament\Pages;

use App\Filament\Widgets;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceFilterPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static string $view = 'filament.pages.attendance-filter-page';

    protected static ?string $title = 'Asistencias';

    protected static ?string $navigationGroup = 'Asistencia y Test';

    protected static ?int $navigationSort = 1;

    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\StatsAttendance::class,
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $today = Carbon::today()->toDateString();
        $attendanceCount = DB::table('attendances')
            ->whereDate('date_attendance', $today)
            ->count();

        return (string) $attendanceCount;
    }

    public static function getNavigationBadgeColor(): string
    {
        $today = Carbon::today()->toDateString();
        $attendanceCount = DB::table('attendances')
            ->whereDate('date_attendance', $today)
            ->count();

        return $attendanceCount > 99 ? 'success' : 'warning';
    }

}
