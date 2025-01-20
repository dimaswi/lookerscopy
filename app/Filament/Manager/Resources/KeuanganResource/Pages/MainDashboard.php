<?php

namespace App\Filament\Manager\Resources\KeuanganResource\Pages;

use App\Filament\Manager\Resources\KeuanganResource;
use Filament\Resources\Pages\Page;

class MainDashboard extends Page
{
    protected static string $resource = KeuanganResource::class;

    protected static string $view = 'filament.manager.resources.keuangan-resource.pages.main-dashboard';

    protected static ?string $title = 'Keuangan Dashboard';
}
