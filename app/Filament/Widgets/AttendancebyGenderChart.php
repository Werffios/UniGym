<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use Filament\Widgets\ChartWidget;

class AttendancebyGenderChart extends ChartWidget
{
    protected static ?string $heading = 'Asistencia por género';

    protected function getData(): array
    {
        $countM = Client::where('gender', 'Masculino')->count();
        $countF = Client::where('gender', 'Femenino')->count();
        return [
            'datasets' => [
                [
                    'data' => [$countM, $countF],
                    'backgroundColor' => ['#add8e6', '#ffcbdb'],
                ],
            ],

            'labels' => ['Masculino', 'Femenino'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
