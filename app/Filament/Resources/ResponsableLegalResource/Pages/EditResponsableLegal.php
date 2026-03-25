<?php

namespace App\Filament\Resources\ResponsableLegalResource\Pages;

use App\Filament\Resources\ResponsableLegalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResponsableLegal extends EditRecord
{
    protected static string $resource = ResponsableLegalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
