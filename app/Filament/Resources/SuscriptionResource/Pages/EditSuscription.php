<?php

namespace App\Filament\Resources\SuscriptionResource\Pages;

use App\Filament\Resources\SuscriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSuscription extends EditRecord
{
    protected static string $resource = SuscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
