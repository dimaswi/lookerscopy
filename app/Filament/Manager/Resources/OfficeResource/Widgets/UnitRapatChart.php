<?php

namespace App\Filament\Manager\Resources\OfficeResource\Widgets;

use App\Models\Rapat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class UnitRapatChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'unitRapatChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Total Rapat Unit';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */

    public $filterData;

    protected function getOptions(): array
    {
        if ($this->filterData == 'Hari') {
            $data = Rapat::whereDate('tanggal_rapat', Carbon::today('Asia/Jakarta')->format('Y-m-d'))
            ->leftJoin('units', 'rapats.unit_id', '=', 'units.id')
            ->select(
                'units.kode_unit as Unit',
                DB::raw('COUNT(*) as total_rapat')
                )
            ->groupBy('Unit')
            ->get();

            $total = $data->pluck('total_rapat');
            $unit = $data->pluck('Unit');
        } else if ($this->filterData == 'Bulan') {
            $awal_bulan = Carbon::now('Asia/Jakarta')->firstOfMonth()->format('Y-m-d');
            $akhir_bulan = Carbon::now('Asia/Jakarta')->lastOfMonth()->format('Y-m-d');

            // dd($awal_bulan, $akhir_bulan);
            $data = Rapat::whereBetween('rapats.tanggal_rapat', [$awal_bulan, $akhir_bulan])
            ->leftJoin('units', 'rapats.unit_id', '=', 'units.id')
            ->select(
                'units.kode_unit as Unit',
                DB::raw('COUNT(*) as total_rapat')
                )
            ->groupBy('Unit')
            ->get();

            $total = $data->pluck('total_rapat');
            $unit = $data->pluck('Unit');

        } else if ($this->filterData == 'Tahun') {
            $awal_tahun = Carbon::now('Asia/Jakarta')->firstOfYear()->format('Y-m-d');
            $akhir_tahun = Carbon::now('Asia/Jakarta')->lastOfYear()->format('Y-m-d');

            // dd($awal_tahun, $akhir_tahun);
            $data = Rapat::whereBetween('rapats.tanggal_rapat', [$awal_tahun, $akhir_tahun])
            ->leftJoin('units', 'rapats.unit_id', '=', 'units.id')
            ->select(
                'units.kode_unit as Unit',
                DB::raw('COUNT(*) as total_rapat')
                )
            ->groupBy('Unit')
            ->get();

            $total = $data->pluck('total_rapat');
            $unit = $data->pluck('Unit');
        }

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'UnitRapatChart',
                    'data' => $total,
                ],
            ],
            'xaxis' => [
                'categories' => $unit,
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
            'colors' => ['#f59e0b'],
        ];
    }
}
