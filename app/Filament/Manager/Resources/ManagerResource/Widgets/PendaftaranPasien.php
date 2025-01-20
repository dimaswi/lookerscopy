<?php

namespace App\Filament\Manager\Resources\ManagerResource\Widgets;

use App\Models\Pendaftaran;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PendaftaranPasien extends BaseWidget
{
    protected function getStats(): array
    {
        // WIDGET HARI INI
        $kemarin = date("Y-m-d", strtotime('-1 days'));
        $pendaftaran_hari_ini = Pendaftaran::whereDate('tanggal', Carbon::today())->get()->count();
        $pendaftaran_kemarin = Pendaftaran::whereDate('tanggal', $kemarin)->get()->count();

        if ($pendaftaran_hari_ini < $pendaftaran_kemarin) {
            $status_hari_ini = 'Berkurang';
            $formula_hari_ini = ($pendaftaran_hari_ini / $pendaftaran_kemarin) * 100;
            $percentage_hari_ini = round(100 - $formula_hari_ini) . '%';
            $icon_hari_ini = 'heroicon-m-arrow-trending-down';
            $color_hari_ini = 'danger';
        } else {
            $status_hari_ini = 'Bertambah';
            $formula_hari_ini = ($pendaftaran_hari_ini / $pendaftaran_kemarin) * 100;
            $percentage_hari_ini = round($formula_hari_ini - 100) . '%';
            $icon_hari_ini = 'heroicon-m-arrow-trending-up';
            $color_hari_ini = 'success';
        }

        //WIDGET BULAN INI
        $pendaftaran_bulan_lalu =  Pendaftaran::whereMonth('tanggal', Carbon::now()->subMonth()->month)->get()->count();
        $pendaftaran_bulan_ini = Pendaftaran::whereMonth('tanggal', Carbon::now()->month)->get()->count();

        if ($pendaftaran_bulan_ini < $pendaftaran_bulan_lalu) {
            $status_bulan_ini = 'Berkurang';
            $formula_bulan_ini = ($pendaftaran_bulan_ini / $pendaftaran_bulan_lalu) * 100;
            $percentage_bulan_ini = round(100 - $formula_bulan_ini) . '%';
            $icon_bulan_ini = 'heroicon-m-arrow-trending-down';
            $color_bulan_ini = 'danger';
        } else {
            $status_bulan_ini = 'Bertambah';
            $formula_bulan_ini = ($pendaftaran_bulan_ini / $pendaftaran_bulan_lalu) * 100;
            $percentage_bulan_ini = round($formula_bulan_ini - 100) . '%';
            $icon_bulan_ini = 'heroicon-m-arrow-trending-up';
            $color_bulan_ini = 'success';
        }

        //WIDGET TAHUN INI
        $pendaftaran_tahun_lalu =  Pendaftaran::whereYear('tanggal', Carbon::now()->subYears()->year)->get()->count();
        $pendaftaran_tahun_ini = Pendaftaran::whereYear('tanggal', Carbon::now()->year)->get()->count();

        if ($pendaftaran_tahun_ini < $pendaftaran_tahun_lalu) {
            $status_tahun_ini = 'Berkurang';
            $formula_tahun_ini = ($pendaftaran_tahun_ini / $pendaftaran_tahun_lalu) * 100;
            $percentage_tahun_ini = round(100 - $formula_tahun_ini) . '%';
            $icon_tahun_ini = 'heroicon-m-arrow-trending-down';
            $color_tahun_ini = 'danger';
        } else {
            $status_tahun_ini = 'Bertambah';
            $formula_tahun_ini = ($pendaftaran_tahun_ini / $pendaftaran_tahun_lalu) * 100;
            $percentage_tahun_ini = round($formula_tahun_ini - 100) . '%';
            $icon_tahun_ini = 'heroicon-m-arrow-trending-up';
            $color_tahun_ini = 'success';
        }

        return [
            Stat::make('Pasien Hari Ini', $pendaftaran_hari_ini)
                ->description($status_hari_ini . ' ' . $percentage_hari_ini)
                ->descriptionIcon($icon_hari_ini)
                ->color($color_hari_ini),
            Stat::make('Pasien Bulan Ini', $pendaftaran_bulan_ini)
                ->description($status_bulan_ini . ' ' . $percentage_bulan_ini)
                ->descriptionIcon($icon_bulan_ini)
                ->color($color_bulan_ini),
            Stat::make('Pasien Tahun Ini', $pendaftaran_tahun_ini)
                ->description($status_tahun_ini . ' ' . $percentage_tahun_ini)
                ->descriptionIcon($icon_tahun_ini)
                ->color($color_tahun_ini),
        ];
    }
}
