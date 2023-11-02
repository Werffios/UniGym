<?php

namespace App\Filament\Resources\AccruedResource\Pages;

use App\Filament\Resources\AccruedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccrued extends EditRecord
{
    protected static string $resource = AccruedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
