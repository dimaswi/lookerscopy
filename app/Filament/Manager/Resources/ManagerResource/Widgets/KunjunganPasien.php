<?php

namespace App\Filament\Manager\Resources\ManagerResource\Widgets;

use App\Models\Kunjungan;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class KunjunganPasien extends BaseWidget
{
    protected function getStats(): array
    {
        $kunjungan = Kunjungan::whereMonth('MASUK', Carbon::now()->month)
            ->leftJoin('master.ruangan', 'master.ruangan.ID', '=', 'pendaftaran.kunjungan.RUANGAN')
            ->select(
                'master.ruangan.DESKRIPSI as nama_ruangan',
                'master.ruangan.ID as ruangan',
                DB::raw('COUNT(*) as total_kunjungan'),
            )
            ->groupBy('RUANGAN')->get();

        $widgets = [];

        foreach ($kunjungan as $key => $value) {

            $kunjungan_kemarin = Kunjungan::whereMonth('MASUK', Carbon::now()->subMonth()->month)->where('RUANGAN', $value->ruangan)->get()->count();

            if ($value->total_kunjungan < $kunjungan_kemarin && $kunjungan_kemarin != 0) {
                $status = 'Berkurang';
                $formula = ($value->total_kunjungan / $kunjungan_kemarin) * 100;
                $persentase = round(100 - $formula) . '%';
                $icon = 'heroicon-m-arrow-trending-down';
                $color = 'danger';
            } else if ($value->total_kunjungan > $kunjungan_kemarin && $kunjungan_kemarin != 0) {
                $status = 'Bertambah';
                $formula = ($value->total_kunjungan / $kunjungan_kemarin) * 100;
                $persentase = round($formula - 100) . '%';
                $icon = 'heroicon-m-arrow-trending-up';
                $color = 'success';
            } else if ($kunjungan_kemarin == 0) {
                $status = 'Bertambah';
                $formula = ($value->total_kunjungan) * 100;
                $persentase = $formula.'%';
                $icon = 'heroicon-m-arrow-trending-up';
                $color = 'success';
            }

            array_push(
                $widgets,
                Stat::make($value->nama_ruangan, $value->total_kunjungan)
                    ->description($status. ' ' .$persentase)
                    ->descriptionIcon($icon)
                    ->color($color),
            );
        }

        return $widgets;
    }
}
