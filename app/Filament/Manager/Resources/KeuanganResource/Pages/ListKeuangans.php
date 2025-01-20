<?php

namespace App\Filament\Manager\Resources\KeuanganResource\Pages;

use App\Filament\Manager\Resources\KeuanganResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKeuangans extends ListRecords
{
    protected static string $resource = KeuanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
