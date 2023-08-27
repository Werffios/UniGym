<?php

namespace App\Filament\Resources\ClientResource\Widgets;

use App\Models\Client;
use App\Models\Attendance;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
class AttendanceOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total de clientes', Client::all()->count())
                ->description('Total de clientes registrados')
                ->color('primary')
                ->chart([0, 12, 20, 25, 47, Client::all()->count()])
                ->icon('heroicon-o-user-group'),
            Stat::make('Asistencias', Attendance::all()->count())
                ->description('Total de asistencias registradas')
                ->color('primary')
                ->chart([0, 23, 56, 78, 123, 345, Attendance::all()->count()])
                ->icon('heroicon-o-clipboard-document-check'),


        ];
    }
    protected static ?string $pollingInterval = '20s';  // Tiempo de actualización de los datos
}
