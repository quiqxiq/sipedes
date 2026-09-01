<?php

namespace App\Filament\Resources\ProgramBantuanResource\Pages;

use App\Filament\Resources\ProgramBantuanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProgramBantuans extends ListRecords
{
    protected static string $resource = ProgramBantuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
