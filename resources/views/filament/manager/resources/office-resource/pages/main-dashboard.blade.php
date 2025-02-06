<x-filament-panels::page>
    <x-filament::section icon="heroicon-o-magnifying-glass">
        <x-slot name="heading">
            Filter Data
        </x-slot>

        <x-filament::input.wrapper>
            <x-filament::input.select wire:model.live="filterData">
                <option value="Hari">Hari</option>
                <option value="Bulan">Bulan</option>
                <option value="Tahun">Tahun</option>
            </x-filament::input.select>
        </x-filament::input.wrapper>
    </x-filament::section>

    <table style="width: 100%">
        <tr>
            <td style="width: 45%; padding-right: 10px">
                <div>
                    @livewire(\App\Filament\Manager\Resources\OfficeResource\Widgets\UnitRapatChart::class, ['filterData' => $filterData], key(Str::random()))
                </div>
            </td>
            <td style="width: 45%; padding-left: 10px">
                <div>
                    @livewire(\App\Filament\Manager\Resources\OfficeResource\Widgets\RankRapatUnitTable::class, ['filterData' => $filterData], key(Str::random()))
                </div>
            </td>
        </tr>
    </table>
</x-filament-panels::page>
