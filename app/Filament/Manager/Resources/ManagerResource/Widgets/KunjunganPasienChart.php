<?php

namespace App\Filament\Manager\Resources\ManagerResource\Widgets;

use App\Models\Kunjungan;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class KunjunganPasienChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'kunjunganPasienChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Kunjungan Pasien Per Bulan';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */

    protected int | string | array $columnSpan = 'full';

    protected function getOptions(): array
    {
        $pendaftaran = Pendaftaran::select(
            DB::raw("COUNT(*) as total"),
            DB::raw("MONTHNAME(TANGGAL) as bulan"),
        )
        ->orderBy('TANGGAL', 'desc')
        ->groupBy(DB::raw("DATE_FORMAT(TANGGAL, '%m-%Y')"))
        ->limit(10)
        ->get();

        $datas = [];
        $labels = [];

        foreach ($pendaftaran as $key => $value) {
            array_push($datas, $value->total);
            array_push($labels, $value->bulan);
        }

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 500,
            ],
            'series' => [
                [
                    'name' => 'BasicBarChart',
                    'data' => $datas,
                ],
            ],
            'xaxis' => [
                'categories' => $labels,
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b', '#C1876B', '#9E9764', '#F3A505', '#CC0605', '#721422', '#EDFF21', '#CFD3CD', '#1E213D', '#924E7D'],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 3,
                    'horizontal' => false,
                    'distributed' => true,
                ],
            ],
        ];
    }
}
