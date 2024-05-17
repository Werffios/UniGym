<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Calculadora extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static string $view = 'filament.pages.calculadora';

    protected static ?string $navigationGroup = 'Asistencia y Test';

    protected static ?int $navigationSort = 2;
}
