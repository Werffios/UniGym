<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use App\Models\Pay;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class PaysbyMonthChart extends ChartWidget
{
    protected static ?string $heading = 'Suscritos por mes en el año';
    protected static string $color = 'primary';

    protected function getData(): array
    {
        Carbon::setLocale('es');
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

            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->isoFormat('MMM')),
        ];
    }


    protected function getType(): string
    {
        return 'bar';
    }
}
