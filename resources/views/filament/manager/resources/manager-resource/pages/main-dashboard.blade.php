<x-filament-panels::page>
    <style>
        .loading-state {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .progress {
            width: 211.2px;
            height: 105.6px;
            border-radius: 352px 352px 0 0;
            -webkit-mask: repeating-radial-gradient(farthest-side at bottom, #0000 0, #000 1px 12%, #0000 calc(12% + 1px) 20%);
            background: radial-gradient(farthest-side at bottom, #474bff 0 95%, #0000 0) bottom/0% 0% no-repeat #dbdcef;
            animation: progress-e37qus 2s infinite steps(6);
        }

        @keyframes progress-e37qus {
            100% {
                background-size: 120% 120%;
            }
        }
    </style>

    <div class="loading-state" wire:loading>
        <center style="padding-top: 25%">
            <div class="progress"></div>
        </center>
    </div>
    <div>
        <x-filament::section>
            <x-slot name="heading">
                Filter Data
            </x-slot>

            <x-filament::input.wrapper>
                <x-filament::input.select wire:model.live="filter">
                    <option value="Hari">Hari</option>
                    <option value="Bulan">Bulan</option>
                    <option value="Tahun">Tahun</option>
                </x-filament::input.select>
            </x-filament::input.wrapper>
        </x-filament::section>

    </div>
    @livewire(\App\Filament\Manager\Resources\ManagerResource\Widgets\PendaftaranPasien::class, ['filterData' => null], key(Str::random()))
    @livewire(\App\Filament\Manager\Resources\ManagerResource\Widgets\KunjunganPasienChart::class, ['filterData' => null], key(Str::random()))

    <table style="width: 100%;">
        <tr>
            <td style="width: 50%; padding-right: 10px">
                @livewire(\App\Filament\Manager\Resources\ManagerResource\Widgets\AsuransiChart::class, ['filterData' => $filter], key(Str::random()))
            </td>
            <td style="width: 50%; padding-left: 10px">
                @livewire(\App\Filament\Manager\Resources\ManagerResource\Widgets\SebaranUmurChart::class, ['filterData' => $filter], key(Str::random()))
            </td>
        </tr>
    </table>
    @livewire(\App\Filament\Manager\Resources\ManagerResource\Widgets\KunjunganPasien::class, ['filter' => $filter], key(Str::random()))
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%; padding-right: 10px">
                @livewire(\App\Filament\Manager\Resources\ManagerResource\Widgets\DesaPasienTable::class, ['filter' => $filter], key(Str::random()))
            </td>
            <td style="width: 50%; padding-left: 10px">
                @livewire(\App\Filament\Manager\Resources\ManagerResource\Widgets\DiagnosaPasien::class, ['filter' => $filter], key(Str::random()))
            </td>
        </tr>
    </table>
</x-filament-panels::page>
