<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class AttendanceFilterPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static string $view = 'filament.pages.attendance-filter-page';

    protected static ?string $title = 'Filtrar asistencias';

    protected static ?string $navigationGroup = 'Asistencia y Test';

    protected static ?int $navigationSort = 1;
}
