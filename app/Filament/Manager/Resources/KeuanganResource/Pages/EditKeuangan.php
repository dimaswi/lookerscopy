<?php

namespace App\Filament\Manager\Resources\KeuanganResource\Pages;

use App\Filament\Manager\Resources\KeuanganResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKeuangan extends EditRecord
{
    protected static string $resource = KeuanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
