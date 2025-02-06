<?php

namespace App\Filament\Manager\Resources\OfficeResource\Pages;

use App\Filament\Manager\Resources\OfficeResource;
use Filament\Resources\Pages\Page;

class MainDashboard extends Page
{
    protected static string $resource = OfficeResource::class;

    protected static string $view = 'filament.manager.resources.office-resource.pages.main-dashboard';

    protected static ?string $title = 'Dashboard Kantor';

    protected static ?string $pollingInterval = null;

    public $filterData = 'Hari';
}
