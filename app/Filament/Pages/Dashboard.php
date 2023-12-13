<?php

namespace App\Filament\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    // ...Widgets\AccountWidget::class,
    protected static ?string $title = 'Resúmenes interactivos';

    protected ?string $subheading = 'En esta sección encontrarás los resúmenes interactivos de los diferentes módulos del sistema.';

    protected function getHeaderWidgets(): array
    {
        return [
        ];
    }


}
