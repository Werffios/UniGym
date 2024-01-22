<?php

namespace App\Filament\Pages;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    // ...Widgets\AccountWidget::class,
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $title = 'Resúmenes interactivos';

    protected ?string $subheading = 'En esta sección encontrarás los resúmenes interactivos de los diferentes módulos del sistema.';





}
