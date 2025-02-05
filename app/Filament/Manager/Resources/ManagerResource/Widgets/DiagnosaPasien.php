<?php

namespace App\Filament\Manager\Resources\ManagerResource\Widgets;

use App\Models\Pendaftaran;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class DiagnosaPasien extends BaseWidget
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
            $query = Pendaftaran::leftJoin('medicalrecord.diagnosa', 'pendaftaran.pendaftaran.NOMOR', '=', 'medicalrecord.diagnosa.NOPEN')
                ->leftJoin('master.diagnosa_masuk', function ($join) {
                    $join->on('medicalrecord.diagnosa.KODE', '=', 'master.diagnosa_masuk.ICD')
                        ->where('master.diagnosa_masuk.DIAGNOSA', '!=', 0);
                })
                ->select(
                    'pendaftaran.pendaftaran.NOMOR as NOMOR',
                    DB::raw('COUNT(*) as total_diagnosa'),
                    'medicalrecord.diagnosa.KODE as diagnosa'
                )
                ->groupBy('medicalrecord.diagnosa.KODE')
                ->whereDate('pendaftaran.pendaftaran.TANGGAL', Carbon::now('Asia/Jakarta'))
                ->orderBy('total_diagnosa', 'desc')
                ->limit(10);
        } else if ($this->filterValue == 'Bulan') {
            $query = Pendaftaran::leftJoin('medicalrecord.diagnosa', 'pendaftaran.pendaftaran.NOMOR', '=', 'medicalrecord.diagnosa.NOPEN')
                ->leftJoin('master.diagnosa_masuk', function ($join) {
                    $join->on('medicalrecord.diagnosa.KODE', '=', 'master.diagnosa_masuk.ICD')
                        ->where('master.diagnosa_masuk.DIAGNOSA', '!=', 0);
                })
                ->select(
                    'pendaftaran.pendaftaran.NOMOR as NOMOR',
                    DB::raw('COUNT(*) as total_diagnosa'),
                    'medicalrecord.diagnosa.KODE as diagnosa'
                )
                ->groupBy('medicalrecord.diagnosa.KODE')
                ->whereMonth('pendaftaran.pendaftaran.TANGGAL', Carbon::now('Asia/Jakarta')->month)
                ->orderBy('total_diagnosa', 'desc')
                ->limit(10);
        } else if ($this->filterValue == 'Tahun') {
            $query = Pendaftaran::leftJoin('medicalrecord.diagnosa', 'pendaftaran.pendaftaran.NOMOR', '=', 'medicalrecord.diagnosa.NOPEN')
                ->leftJoin('master.diagnosa_masuk', function ($join) {
                    $join->on('medicalrecord.diagnosa.KODE', '=', 'master.diagnosa_masuk.ICD')
                        ->where('master.diagnosa_masuk.DIAGNOSA', '!=', 0);
                })
                ->select(
                    'pendaftaran.pendaftaran.NOMOR as NOMOR',
                    DB::raw('COUNT(*) as total_diagnosa'),
                    'medicalrecord.diagnosa.KODE as diagnosa'
                )
                ->groupBy('medicalrecord.diagnosa.KODE')
                ->whereYear('pendaftaran.pendaftaran.TANGGAL', Carbon::now('Asia/Jakarta')->year)
                ->orderBy('total_diagnosa', 'desc')
                ->limit(10);
        } else {
            $query = Pendaftaran::leftJoin('medicalrecord.diagnosa', 'pendaftaran.pendaftaran.NOMOR', '=', 'medicalrecord.diagnosa.NOPEN')
                ->leftJoin('master.diagnosa_masuk', function ($join) {
                    $join->on('medicalrecord.diagnosa.KODE', '=', 'master.diagnosa_masuk.ICD')
                        ->where('master.diagnosa_masuk.DIAGNOSA', '!=', 0);
                })
                ->select(
                    'pendaftaran.pendaftaran.NOMOR as NOMOR',
                    DB::raw('COUNT(*) as total_diagnosa'),
                    'medicalrecord.diagnosa.KODE as diagnosa'
                )
                ->groupBy('medicalrecord.diagnosa.KODE')
                ->orderBy('total_diagnosa', 'desc')
                ->limit(10);
        }
        return $table
            ->paginated(false)
            ->query(
                $query
            )
            ->columns([
                TextColumn::make('index')
                    ->label('No. ')
                    ->rowIndex(),
                TextColumn::make('diagnosa'),
                TextColumn::make('total_diagnosa')->alignCenter()->badge(),
            ])
            ->emptyState(view('table.filament.empty-state'));
    }
}
