<?php

namespace App\Filament\Widgets;

use App\Models\Pay;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ClientsbyDegreeChart extends ChartWidget
{
    protected static ?string $heading = 'Suscritos por mes';
    protected static string $color = 'primary';

    protected function getData(): array
    {
        $data = Trend::model(Pay::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Suscripciones',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
