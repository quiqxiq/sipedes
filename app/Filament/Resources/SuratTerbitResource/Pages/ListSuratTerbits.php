<?php

namespace App\Filament\Resources\SuratTerbitResource\Pages;

use App\Filament\Resources\SuratTerbitResource;
use Filament\Resources\Pages\ListRecords;

class ListSuratTerbits extends ListRecords
{
    protected static string $resource = SuratTerbitResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
