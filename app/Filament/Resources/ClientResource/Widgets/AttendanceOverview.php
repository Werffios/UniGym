<?php

namespace App\Filament\Resources\ClientResource\Widgets;

use App\Models\Client;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
class AttendanceOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total de clientes', Client::count()),
            Stat::make('Clientes activos', Client::where('active', true)->count()),


        ];
    }
    /**
     * @var view-string
     */
    protected static ?string $pollingInterval = '4s';  // Tiempo de actualización de los datos
}
