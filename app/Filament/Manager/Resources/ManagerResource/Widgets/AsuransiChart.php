<?php

namespace App\Filament\Manager\Resources\ManagerResource\Widgets;

use App\Models\Penjamin;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class AsuransiChart extends ApexChartWidget
{

    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'asuransiChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Chart Penjamin Pasien';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */

    protected static ?string $pollingInterval = null;


    protected function getOptions(): array
    {
        if ($this->filterData == 'Hari') {
            $penjamin = Penjamin::select(
                DB::raw("COUNT(*) as total_data"),
                'master.referensi.DESKRIPSI as penjamin'
            )
                ->leftJoin('pendaftaran.pendaftaran', 'pendaftaran.pendaftaran.NOMOR', '=', 'pendaftaran.penjamin.NOPEN')
                ->leftJoin('master.referensi', function ($join) {
                    $join->on('pendaftaran.penjamin.JENIS', '=', 'master.referensi.ID')->where('master.referensi.JENIS', 10);
                })
                ->whereDate('pendaftaran.pendaftaran.TANGGAL', Carbon::now('Asia/Jakarta'))
                ->groupBy('pendaftaran.penjamin.JENIS')
                ->get();
        } else if ($this->filterData == 'Bulan') {
            $penjamin = Penjamin::select(
                DB::raw("COUNT(*) as total_data"),
                'master.referensi.DESKRIPSI as penjamin'
            )
                ->leftJoin('pendaftaran.pendaftaran', 'pendaftaran.pendaftaran.NOMOR', '=', 'pendaftaran.penjamin.NOPEN')
                ->leftJoin('master.referensi', function ($join) {
                    $join->on('pendaftaran.penjamin.JENIS', '=', 'master.referensi.ID')->where('master.referensi.JENIS', 10);
                })
                ->whereMonth('pendaftaran.pendaftaran.TANGGAL', Carbon::now('Asia/Jakarta')->month)
                ->groupBy('pendaftaran.penjamin.JENIS')
                ->get();
        } else if ($this->filterData == 'Tahun') {
            $penjamin = Penjamin::select(
                DB::raw("COUNT(*) as total_data"),
                'master.referensi.DESKRIPSI as penjamin'
            )
                ->leftJoin('pendaftaran.pendaftaran', 'pendaftaran.pendaftaran.NOMOR', '=', 'pendaftaran.penjamin.NOPEN')
                ->leftJoin('master.referensi', function ($join) {
                    $join->on('pendaftaran.penjamin.JENIS', '=', 'master.referensi.ID')->where('master.referensi.JENIS', 10);
                })
                ->whereYear('pendaftaran.pendaftaran.TANGGAL', Carbon::now('Asia/Jakarta')->year)
                ->groupBy('pendaftaran.penjamin.JENIS')
                ->get();
        } else {
            $penjamin = Penjamin::select(
                DB::raw("COUNT(*) as total_data"),
                'master.referensi.DESKRIPSI as penjamin'
            )
                ->leftJoin('pendaftaran.pendaftaran', 'pendaftaran.pendaftaran.NOMOR', '=', 'pendaftaran.penjamin.NOPEN')
                ->leftJoin('master.referensi', function ($join) {
                    $join->on('pendaftaran.penjamin.JENIS', '=', 'master.referensi.ID')->where('master.referensi.JENIS', 10);
                })
                ->whereMonth('pendaftaran.pendaftaran.TANGGAL', Carbon::now()->month)
                ->groupBy('pendaftaran.penjamin.JENIS')
                ->get();
        }

        $datas = [];
        $labels = [];
        $colors = [];

        foreach ($penjamin as $value) {
            array_push($datas, $value->total_data);
            array_push($labels, $value->penjamin);
            array_push($colors, '#' . substr(md5(rand()), 0, 6));
        }

        return [
            'chart' => [
                'type' => 'donut',
                'height' => 300,
            ],
            'series' => $datas,
            'labels' => $labels,
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
        ];
    }
}
