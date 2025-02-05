<?php

namespace App\Filament\Manager\Resources\ManagerResource\Widgets;

use App\Models\Pasien;
use App\Models\Pendaftaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class SebaranUmurChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'sebaranUmurChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Chart Sebaran Umur Pasien';

    protected static ?string $pollingInterval = null;

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */

    protected function getOptions(): array
    {
        if ($this->filterData == 'Hari') {
            $anak_anak = Pendaftaran::leftJoin('master.pasien', 'pendaftaran.pendaftaran.NORM', '=', 'master.pasien.NORM')
                ->whereBetween('master.pasien.TANGGAL_LAHIR', [Carbon::now('Asia/Jakarta')->subYears(17), Carbon::now('Asia/Jakarta')])
                ->whereDate('pendaftaran.pendaftaran.TANGGAL', Carbon::now('Asia/Jakarta'))
                ->get()
                ->count();
            $dewasa = Pendaftaran::leftJoin('master.pasien', 'pendaftaran.pendaftaran.NORM', '=', 'master.pasien.NORM')
                ->whereBetween('master.pasien.TANGGAL_LAHIR', [Carbon::now('Asia/Jakarta')->subYears(50), Carbon::now('Asia/Jakarta')->subYears(17)])
                ->whereDate('pendaftaran.pendaftaran.TANGGAL', Carbon::now('Asia/Jakarta'))
                ->get()
                ->count();
            $lansia = Pendaftaran::leftJoin('master.pasien', 'pendaftaran.pendaftaran.NORM', '=', 'master.pasien.NORM')
                ->whereDate('master.pasien.TANGGAL_LAHIR', '<=', Carbon::now('Asia/Jakarta')->subYears(50))
                ->whereDate('pendaftaran.pendaftaran.TANGGAL', Carbon::now('Asia/Jakarta'))
                ->get()
                ->count();
        } else if ($this->filterData == 'Bulan') {
            $anak_anak = Pendaftaran::leftJoin('master.pasien', 'pendaftaran.pendaftaran.NORM', '=', 'master.pasien.NORM')
                ->whereBetween('master.pasien.TANGGAL_LAHIR', [Carbon::now('Asia/Jakarta')->subYears(17), Carbon::now('Asia/Jakarta')])
                ->whereMonth('pendaftaran.pendaftaran.TANGGAL', Carbon::now('Asia/Jakarta')->month)
                ->get()
                ->count();
            $dewasa = Pendaftaran::leftJoin('master.pasien', 'pendaftaran.pendaftaran.NORM', '=', 'master.pasien.NORM')
                ->whereBetween('master.pasien.TANGGAL_LAHIR', [Carbon::now('Asia/Jakarta')->subYears(50), Carbon::now('Asia/Jakarta')->subYears(17)])
                ->whereMonth('pendaftaran.pendaftaran.TANGGAL', Carbon::now('Asia/Jakarta')->month)
                ->get()
                ->count();
            $lansia = Pendaftaran::leftJoin('master.pasien', 'pendaftaran.pendaftaran.NORM', '=', 'master.pasien.NORM')
                ->whereDate('master.pasien.TANGGAL_LAHIR', '<=', Carbon::now('Asia/Jakarta')->subYears(50))
                ->whereMonth('pendaftaran.pendaftaran.TANGGAL', Carbon::now('Asia/Jakarta')->month)
                ->get()
                ->count();
        } else if ($this->filterData == 'Tahun') {
            $anak_anak = Pendaftaran::leftJoin('master.pasien', 'pendaftaran.pendaftaran.NORM', '=', 'master.pasien.NORM')
                ->whereBetween('master.pasien.TANGGAL_LAHIR', [Carbon::now('Asia/Jakarta')->subYears(17), Carbon::now('Asia/Jakarta')])
                ->whereYear('pendaftaran.pendaftaran.TANGGAL', Carbon::now('Asia/Jakarta')->year)
                ->get()
                ->count();
            $dewasa = Pendaftaran::leftJoin('master.pasien', 'pendaftaran.pendaftaran.NORM', '=', 'master.pasien.NORM')
                ->whereBetween('master.pasien.TANGGAL_LAHIR', [Carbon::now('Asia/Jakarta')->subYears(50), Carbon::now('Asia/Jakarta')->subYears(17)])
                ->whereYear('pendaftaran.pendaftaran.TANGGAL', Carbon::now('Asia/Jakarta')->year)
                ->get()
                ->count();
            $lansia = Pendaftaran::leftJoin('master.pasien', 'pendaftaran.pendaftaran.NORM', '=', 'master.pasien.NORM')
                ->whereDate('master.pasien.TANGGAL_LAHIR', '<=', Carbon::now('Asia/Jakarta')->subYears(50))
                ->whereYear('pendaftaran.pendaftaran.TANGGAL', Carbon::now('Asia/Jakarta')->year)
                ->get()
                ->count();
        } else {
            $anak_anak = Pendaftaran::leftJoin('master.pasien', 'pendaftaran.pendaftaran.NORM', '=', 'master.pasien.NORM')
                ->whereBetween('master.pasien.TANGGAL_LAHIR', [Carbon::now('Asia/Jakarta')->subYears(17), Carbon::now('Asia/Jakarta')])
                ->whereDate('pendaftaran.pendaftaran.TANGGAL', Carbon::now('Asia/Jakarta'))
                ->get()
                ->count();
            $dewasa = Pendaftaran::leftJoin('master.pasien', 'pendaftaran.pendaftaran.NORM', '=', 'master.pasien.NORM')
                ->whereBetween('master.pasien.TANGGAL_LAHIR', [Carbon::now('Asia/Jakarta')->subYears(50), Carbon::now('Asia/Jakarta')->subYears(17)])
                ->whereDate('pendaftaran.pendaftaran.TANGGAL', Carbon::now('Asia/Jakarta'))
                ->get()
                ->count();
            $lansia = Pendaftaran::leftJoin('master.pasien', 'pendaftaran.pendaftaran.NORM', '=', 'master.pasien.NORM')
                ->whereDate('master.pasien.TANGGAL_LAHIR', '<=', Carbon::now('Asia/Jakarta')->subYears(50))
                ->whereDate('pendaftaran.pendaftaran.TANGGAL', Carbon::now('Asia/Jakarta'))
                ->get()
                ->count();
        }

        return [
            'chart' => [
                'type' => 'donut',
                'height' => 300,
            ],
            'series' => [$anak_anak, $dewasa, $lansia],
            'labels' => ['Anak-Anak', 'Dewasa', 'Lansia'],
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
        ];
    }
}
