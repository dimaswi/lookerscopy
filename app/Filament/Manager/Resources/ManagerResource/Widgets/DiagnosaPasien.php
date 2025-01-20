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
    public function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->query(
                Pendaftaran::leftJoin('medicalrecord.diagnosa', 'pendaftaran.pendaftaran.NOMOR', '=', 'medicalrecord.diagnosa.NOPEN')
                ->leftJoin('master.diagnosa_masuk', function ($join) {
                    $join->on('medicalrecord.diagnosa.KODE', '=', 'master.diagnosa_masuk.ICD')
                    ->where('master.diagnosa_masuk.DIAGNOSA', '!=', 0);
                })
                ->select(
                    'pendaftaran.pendaftaran.NOMOR as NOMOR',
                    DB::raw('COUNT(*) as total_diagnosa'),
                    'medicalrecord.diagnosa.KODE as diagnosa'
                )
                ->whereMonth('medicalrecord.diagnosa.TANGGAL', Carbon::now()->month)
                ->groupBy('medicalrecord.diagnosa.KODE')
                ->orderBy('total_diagnosa', 'desc')
                ->limit(10)
            )
            ->columns([
                TextColumn::make('diagnosa'),
                TextColumn::make('total_diagnosa')->alignCenter()->badge(),
            ]);
    }
}
