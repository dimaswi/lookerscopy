<?php

namespace App\Filament\Manager\Resources\ManagerResource\Pages;

use App\Filament\Manager\Resources\ManagerResource;
use App\Filament\Manager\Resources\ManagerResource\Widgets\AsuransiChart;
use App\Filament\Manager\Resources\ManagerResource\Widgets\DiagnosaPasien;
use App\Filament\Manager\Resources\ManagerResource\Widgets\KunjunganPasien;
use App\Filament\Manager\Resources\ManagerResource\Widgets\KunjunganPasienChart;
use App\Filament\Manager\Resources\ManagerResource\Widgets\PendaftaranPasien;
use Filament\Resources\Pages\Page;

class MainDashboard extends Page
{
    protected static string $resource = ManagerResource::class;

    protected static string $view = 'filament.manager.resources.manager-resource.pages.main-dashboard';

    protected static ?string $title = 'Manager Dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            AsuransiChart::class,
            DiagnosaPasien::class,
            PendaftaranPasien::class,
            KunjunganPasien::class,
            KunjunganPasienChart::class
        ];
    }
}
