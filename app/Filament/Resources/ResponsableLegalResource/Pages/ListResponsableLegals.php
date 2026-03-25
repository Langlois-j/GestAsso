<?php

namespace App\Filament\Resources\ResponsableLegalResource\Pages;

use App\Filament\Resources\ResponsableLegalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListResponsableLegals extends ListRecords
{
    protected static string $resource = ResponsableLegalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
