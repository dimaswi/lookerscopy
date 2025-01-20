<?php

namespace App\Filament\Manager\Resources\ManagerResource\Widgets;

use App\Models\Pasien;
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

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $anak_anak = Pasien::whereBetween('TANGGAL_LAHIR',[Carbon::now()->subYears(17),Carbon::now()])
        ->select(
            'NAMA'
        )
        ->get();

        $dewasa = Pasien::whereBetween('TANGGAL_LAHIR',[Carbon::now()->subYears(50),Carbon::now()->subYears(17)])
        ->select(
            'NAMA'
        )
        ->get();

        $lansia = Pasien::whereDate('TANGGAL_LAHIR', '>=', Carbon::now()->subYears(50))
        ->select(
            'NAMA'
        )
        ->get();

        return [
            'chart' => [
                'type' => 'donut',
                'height' => 300,
            ],
            'series' => [$anak_anak->count(), $dewasa->count(), $lansia->count()],
            'labels' => ['Anak-Anak', 'Dewasa', 'Lansia'],
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
        ];
    }
}
