<?php

namespace App\Filament\Manager\Resources\ManagerResource\Pages;

use App\Filament\Manager\Resources\ManagerResource;
use App\Filament\Manager\Resources\ManagerResource\Widgets\AsuransiChart;
use App\Filament\Manager\Resources\ManagerResource\Widgets\DesaPasienTable;
use App\Filament\Manager\Resources\ManagerResource\Widgets\DiagnosaPasien;
use App\Filament\Manager\Resources\ManagerResource\Widgets\KunjunganPasien;
use App\Filament\Manager\Resources\ManagerResource\Widgets\KunjunganPasienChart;
use App\Filament\Manager\Resources\ManagerResource\Widgets\PendaftaranPasien;
use App\Filament\Manager\Resources\ManagerResource\Widgets\SebaranUmumChart;
use App\Filament\Manager\Resources\ManagerResource\Widgets\SebaranUmurChart;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Resources\Pages\Page;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class MainDashboard extends Page
{
    protected static string $resource = ManagerResource::class;

    protected static string $view = 'filament.manager.resources.manager-resource.pages.main-dashboard';

    protected static ?string $title = 'Manager Dashboard';

    use InteractsWithForms;

    public ?array $data = [];

    public $filter = 'Hari';

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('filter_waktu')
                    ->hiddenLabel()
                    ->default('Hari')
                    ->live()
                    ->options([
                        'Hari' => 'Hari',
                        'Bulan' => 'Bulan',
                        'Tahun' => 'Tahun',
                    ])
                    ->selectablePlaceholder(false)
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        // $this->filterValue = $this->form->getState()['filter_waktu']?? 'Hari';
        // dd($this->filterValue);
    }

    // protected function getHeaderWidgets(): array
    // {
    //     return [
    //         AsuransiChart::class,
    //         SebaranUmurChart::class,
    //         PendaftaranPasien::class,
    //         KunjunganPasien::class,
    //         KunjunganPasienChart::class,
    //         DesaPasienTable::class,
    //         DiagnosaPasien::class,
    //     ];
    // }
}
