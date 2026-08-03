<?php

namespace App\Filament\Resources\PermohonanSuratResource\Pages;

use App\Filament\Resources\PermohonanSuratResource;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPermohonanSurats extends ListRecords
{
    protected static string $resource = PermohonanSuratResource::class;

    public function getTabs(): array
    {
        return [
            'semua' => Tab::make('Semua Status'),
            'diajukan' => Tab::make('Diajukan')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'diajukan'))
                ->badge(fn () => static::getResource()::getEloquentQuery()->where('status', 'diajukan')->count()),
            'diproses' => Tab::make('Diproses')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'diproses'))
                ->badge(fn () => static::getResource()::getEloquentQuery()->where('status', 'diproses')->count()),
            'disetujui' => Tab::make('Disetujui')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'disetujui'))
                ->badge(fn () => static::getResource()::getEloquentQuery()->where('status', 'disetujui')->count()),
            'butuh_koreksi' => Tab::make('Butuh Koreksi')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'butuh_koreksi'))
                ->badge(fn () => static::getResource()::getEloquentQuery()->where('status', 'butuh_koreksi')->count()),
            'ditolak' => Tab::make('Ditolak')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'ditolak'))
                ->badge(fn () => static::getResource()::getEloquentQuery()->where('status', 'ditolak')->count()),
        ];
    }
}
