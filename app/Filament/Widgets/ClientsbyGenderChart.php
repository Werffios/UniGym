<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use Filament\Widgets\ChartWidget;

class ClientsbyGenderChart extends ChartWidget
{
    protected static ?string $heading = 'Usuarios por género';
    protected static ?int $sort = 3;

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
