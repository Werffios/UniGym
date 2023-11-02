<?php

namespace App\Filament\Resources\SuscriptionResource\Pages;

use App\Filament\Resources\SuscriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuscriptions extends ListRecords
{
    protected static string $resource = SuscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
