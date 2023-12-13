<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AttendancebyMonthChart extends ChartWidget
{
    protected static ?string $heading = 'Asistencias por dia en la semana';
    protected function getData(): array
    {
        $data = Trend::model(Attendance::class)
            ->between(
                start: now()->startOfWeek(),
                end: now()->endOfWeek(),
            )
            ->perDay()
            ->count();
        Carbon::setLocale('es');
        return [
            'datasets' => [
                [
                    'label' => 'Asistencias',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],

            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->isoFormat('ddd')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
