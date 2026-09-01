<?php

namespace App\Filament\Resources\ProgramBantuanResource\Pages;

use App\Filament\Resources\ProgramBantuanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProgramBantuan extends EditRecord
{
    protected static string $resource = ProgramBantuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
