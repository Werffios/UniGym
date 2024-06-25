<?php

namespace App\Filament\Resources\ClientResource\Widgets;

use App\Models\Client;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Support\Enums\IconPosition;

class AttendanceOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total de usuarios', Client::count())
            ->description('Usuarios registrados')
            ->descriptionIcon('heroicon-s-user-group', IconPosition::Before)
            ->color('info')
            ->chart([200, 120, 80, 30, 10, 5]),
            Stat::make('Usuarios activos', Client::where('active', true)->count())
            ->description('N° de usuarios activos')
            ->descriptionIcon('heroicon-s-user-plus', IconPosition::Before)
            ->color('success'),


        ];
    }
    /**
     * @var view-string
     */
    protected static ?string $pollingInterval = '4s';  // Tiempo de actualización de los datos
}
