<?php

namespace App\Filament\Manager\Resources\ManagerResource\Widgets;

use App\Models\Kunjungan;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class KunjunganPasien extends BaseWidget
{
    public $filter;

    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        if ($this->filter == 'Hari') {
            $kunjungan = Kunjungan::whereDate('MASUK', Carbon::now('Asia/Jakarta'))
                ->leftJoin('master.ruangan', 'master.ruangan.ID', '=', 'pendaftaran.kunjungan.RUANGAN')
                ->select(
                    'master.ruangan.DESKRIPSI as nama_ruangan',
                    'master.ruangan.ID as ruangan',
                    DB::raw('COUNT(*) as total_kunjungan'),
                )
                ->groupBy('RUANGAN')->get();

            $widgets = [];

            foreach ($kunjungan as $key => $value) {

                $kunjungan_kemarin = Kunjungan::whereDate('MASUK', Carbon::now('Asia/Jakarta')->subDay())->where('RUANGAN', $value->ruangan)->get()->count();
                // dd($value->total_kunjungan, $kunjungan_kemarin);
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
                    $persentase = $formula . '%';
                    $icon = 'heroicon-m-arrow-trending-up';
                    $color = 'success';
                } else if ($kunjungan_kemarin == $value->total_kunjungan) {
                    $status = 'Tidak ada perubahan';
                    // $formula = ($value->total_kunjungan) * 100;
                    $persentase = '0%';
                    $icon = 'heroicon-m-minus';
                    $color = 'warning';
                }

                array_push(
                    $widgets,
                    Stat::make($value->nama_ruangan, $value->total_kunjungan)
                        ->description($status . ' ' . $persentase)
                        ->descriptionIcon($icon)
                        ->color($color),
                );
            }
        } else if ($this->filter == 'Bulan') {
            $kunjungan = Kunjungan::whereMonth('MASUK', Carbon::now('Asia/Jakarta')->month)
                ->leftJoin('master.ruangan', 'master.ruangan.ID', '=', 'pendaftaran.kunjungan.RUANGAN')
                ->select(
                    'master.ruangan.DESKRIPSI as nama_ruangan',
                    'master.ruangan.ID as ruangan',
                    DB::raw('COUNT(*) as total_kunjungan'),
                )
                ->groupBy('RUANGAN')->get();

            $widgets = [];

            foreach ($kunjungan as $key => $value) {

                $kunjungan_kemarin = Kunjungan::whereMonth('MASUK', Carbon::now('Asia/Jakarta')->subMonth()->month)->where('RUANGAN', $value->ruangan)->get()->count();

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
                    $persentase = $formula . '%';
                    $icon = 'heroicon-m-arrow-trending-up';
                    $color = 'success';
                } else if ($kunjungan_kemarin == $value->total_kunjungan) {
                    $status = 'Tidak ada perubahan';
                    // $formula = ($value->total_kunjungan) * 100;
                    $persentase = '0%';
                    $icon = 'heroicon-m-minus';
                    $color = 'warning';
                }

                array_push(
                    $widgets,
                    Stat::make($value->nama_ruangan, $value->total_kunjungan)
                        ->description($status . ' ' . $persentase)
                        ->descriptionIcon($icon)
                        ->color($color),
                );
            }
        } else if ($this->filter == 'Tahun') {
            $kunjungan = Kunjungan::whereYear('MASUK', Carbon::now('Asia/Jakarta')->year)
                ->leftJoin('master.ruangan', 'master.ruangan.ID', '=', 'pendaftaran.kunjungan.RUANGAN')
                ->select(
                    'master.ruangan.DESKRIPSI as nama_ruangan',
                    'master.ruangan.ID as ruangan',
                    DB::raw('COUNT(*) as total_kunjungan'),
                )
                ->groupBy('RUANGAN')->get();

            $widgets = [];

            foreach ($kunjungan as $key => $value) {

                $kunjungan_kemarin = Kunjungan::whereYear('MASUK', Carbon::now('Asia/Jakarta')->subYear()->year)->where('RUANGAN', $value->ruangan)->get()->count();

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
                    $persentase = $formula . '%';
                    $icon = 'heroicon-m-arrow-trending-up';
                    $color = 'success';
                } else if ($kunjungan_kemarin == $value->total_kunjungan) {
                    $status = 'Tidak ada perubahan';
                    // $formula = ($value->total_kunjungan) * 100;
                    $persentase = '0%';
                    $icon = 'heroicon-m-minus';
                    $color = 'warning';
                }

                array_push(
                    $widgets,
                    Stat::make($value->nama_ruangan, $value->total_kunjungan)
                        ->description($status . ' ' . $persentase)
                        ->descriptionIcon($icon)
                        ->color($color),
                );
            }
        }

        return $widgets;
    }
}
