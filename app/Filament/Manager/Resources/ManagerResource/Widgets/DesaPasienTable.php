<?php

namespace App\Filament\Manager\Resources\ManagerResource\Widgets;

use App\Models\Pendaftaran;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class DesaPasienTable extends BaseWidget
{
    public $filterValue;

    protected static ?string $pollingInterval = null;

    public function mount($filter)
    {
        $this->filterValue = $filter;
    }

    public function table(Table $table): Table
    {
        if ($this->filterValue == 'Hari') {
            $query = Pendaftaran::leftJoin('master.pasien', 'master.pasien.NORM', '=', 'pendaftaran.pendaftaran.NORM')
                    ->leftJoin('master.wilayah', 'master.wilayah.ID', '=', 'master.pasien.WILAYAH')
                    ->select(
                        'pendaftaran.pendaftaran.NOMOR as NOMOR',
                        DB::raw("COUNT(*) as total"),
                        'master.wilayah.DESKRIPSI as desa'
                    )
                    ->whereDate('pendaftaran.pendaftaran.TANGGAL', Carbon::now('Asia/Jakarta'))
                    ->groupBy('master.wilayah.DESKRIPSI')
                    ->orderBy('total', 'desc')
                    ->limit(10);
        } else if ($this->filterValue == 'Bulan') {
            $query = Pendaftaran::leftJoin('master.pasien', 'master.pasien.NORM', '=', 'pendaftaran.pendaftaran.NORM')
                    ->leftJoin('master.wilayah', 'master.wilayah.ID', '=', 'master.pasien.WILAYAH')
                    ->select(
                        'pendaftaran.pendaftaran.NOMOR as NOMOR',
                        DB::raw("COUNT(*) as total"),
                        'master.wilayah.DESKRIPSI as desa'
                    )
                    ->whereMonth('pendaftaran.pendaftaran.TANGGAL', Carbon::now('Asia/Jakarta')->month)
                    ->groupBy('master.wilayah.DESKRIPSI')
                    ->orderBy('total', 'desc')
                    ->limit(10);
        } else if ($this->filterValue == 'Tahun') {
            $query = Pendaftaran::leftJoin('master.pasien', 'master.pasien.NORM', '=', 'pendaftaran.pendaftaran.NORM')
                    ->leftJoin('master.wilayah', 'master.wilayah.ID', '=', 'master.pasien.WILAYAH')
                    ->select(
                        'pendaftaran.pendaftaran.NOMOR as NOMOR',
                        DB::raw("COUNT(*) as total"),
                        'master.wilayah.DESKRIPSI as desa'
                    )
                    ->whereYear('pendaftaran.pendaftaran.TANGGAL', Carbon::now('Asia/Jakarta')->year)
                    ->groupBy('master.wilayah.DESKRIPSI')
                    ->orderBy('total', 'desc')
                    ->limit(10);
        } else {
            $query = Pendaftaran::leftJoin('master.pasien', 'master.pasien.NORM', '=', 'pendaftaran.pendaftaran.NORM')
                    ->leftJoin('master.wilayah', 'master.wilayah.ID', '=', 'master.pasien.WILAYAH')
                    ->select(
                        'pendaftaran.pendaftaran.NOMOR as NOMOR',
                        DB::raw("COUNT(*) as total"),
                        'master.wilayah.DESKRIPSI as desa'
                    )
                    ->groupBy('master.wilayah.DESKRIPSI')
                    ->orderBy('total', 'desc')
                    ->limit(10);
        }
        // dump($this->filter);
        return $table
            ->paginated(false)
            ->query(
                $query
            )
            ->columns([
                TextColumn::make('index')
                    ->label('No. ')
                    ->rowIndex(),
                TextColumn::make('desa'),
                TextColumn::make('total')->alignCenter()->badge(),
            ])
            ->emptyState(view('table.filament.empty-state'));
    }
}
