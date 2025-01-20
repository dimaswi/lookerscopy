<?php

namespace App\Filament\Manager\Resources\ManagerResource\Widgets;

use App\Models\Pendaftaran;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class DesaPasienTable extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->query(
                Pendaftaran::leftJoin('master.pasien', 'master.pasien.NORM', '=', 'pendaftaran.pendaftaran.NORM')
                    ->leftJoin('master.wilayah', 'master.wilayah.ID', '=', 'master.pasien.WILAYAH')
                    ->select(
                        'pendaftaran.pendaftaran.NOMOR as NOMOR',
                        DB::raw("COUNT(*) as total"),
                        'master.wilayah.DESKRIPSI as desa'
                    )
                    ->groupBy('master.wilayah.DESKRIPSI')
                    ->orderBy('total', 'desc')
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('index')
                    ->label('No. ')
                    ->rowIndex(),
                TextColumn::make('desa'),
                TextColumn::make('total')->alignCenter()->badge(),
            ]);
    }
}
