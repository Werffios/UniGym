<?php

namespace App\Filament\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    // ...Widgets\AccountWidget::class,
    protected static ?string $title = 'Resúmenes interactivos';

    protected function getHeaderWidgets(): array
    {
        return [

        ];
    }


}
