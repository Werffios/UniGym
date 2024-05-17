<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;

class AttendancebyMonthChart extends ChartWidget
{
    protected static ?string $heading = 'Asistencias por día del mes';

    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 2;
    protected function getData(): array
    {
        $data = Trend::model(Attendance::class)
            ->between(
                start: now()->subMonths(1),
                end: now(),
            )
            ->perDay()
            ->count();
        Carbon::setLocale('es');
        return [
            'datasets' => [
                [
                    'label' => 'Asistencias',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgb(241, 148, 138)',
                    'borderColor' => 'rgb(205, 97, 85)',
                    'borderWidth' => 2,
                ],
            ],

            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->isoFormat('ddd/DD/MM')),
            
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
