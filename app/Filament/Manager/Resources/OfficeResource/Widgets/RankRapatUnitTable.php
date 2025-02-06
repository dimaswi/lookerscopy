<?php

namespace App\Filament\Manager\Resources\OfficeResource\Widgets;

use App\Models\Rapat;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class RankRapatUnitTable extends BaseWidget
{
    public $filterData;

    public function table(Table $table): Table
    {
        if ($this->filterData == 'Hari') {
            $query = Rapat::whereDate('tanggal_rapat', Carbon::today('Asia/Jakarta')->format('Y-m-d'))
                ->leftJoin('units', 'rapats.unit_id', '=', 'units.id')
                ->select(
                    'units.kode_unit as Unit',
                    'units.kode_unit as NAMA',
                    DB::raw('COUNT(*) as total_rapat')
                )
                ->groupBy('Unit')
                ->orderBy('total_rapat', 'desc');
        } else if ($this->filterData == 'Bulan') {
            $awal_bulan = Carbon::now('Asia/Jakarta')->firstOfMonth()->format('Y-m-d');
            $akhir_bulan = Carbon::now('Asia/Jakarta')->lastOfMonth()->format('Y-m-d');
            $query = Rapat::whereBetween('rapats.tanggal_rapat', [$awal_bulan, $akhir_bulan])
                ->leftJoin('units', 'rapats.unit_id', '=', 'units.id')
                ->select(
                    'units.kode_unit as Unit',
                    'units.kode_unit as NAMA',
                    DB::raw('COUNT(*) as total_rapat')
                )
                ->groupBy('Unit')
                ->orderBy('total_rapat', 'desc');
        } else if ($this->filterData == 'Tahun') {
            $awal_tahun = Carbon::now('Asia/Jakarta')->firstOfYear()->format('Y-m-d');
            $akhir_tahun = Carbon::now('Asia/Jakarta')->lastOfYear()->format('Y-m-d');
            $query = Rapat::whereBetween('rapats.tanggal_rapat', [$awal_tahun, $akhir_tahun])
                ->leftJoin('units', 'rapats.unit_id', '=', 'units.id')
                ->select(
                    'units.kode_unit as Unit',
                    'units.kode_unit as NAMA',
                    DB::raw('COUNT(*) as total_rapat')
                )
                ->groupBy('Unit')
                ->orderBy('total_rapat', 'desc');
        }
        return $table
            ->paginated(false)
            ->query(
                // dd($query->get())
                $query->limit(10)
            )
            ->columns([
                TextColumn::make('index')
                    ->label('No.')
                    ->rowIndex()
                    ->alignCenter()
                    ->extraAttributes([
                        'class' => 'width:10%'
                    ]),
                TextColumn::make('NAMA'),
                TextColumn::make('total_rapat')
                    ->alignCenter()
                    ->badge()
            ])
            ->emptyState(view('table.filament.empty-state'));;
    }
}
