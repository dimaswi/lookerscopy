<?php

namespace App\Filament\Manager\Resources;

use App\Filament\Manager\Resources\ManagerResource\Pages;
use App\Filament\Manager\Resources\ManagerResource\RelationManagers;
use App\Models\Manager;
use App\Models\Pendaftaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ManagerResource extends Resource
{
    protected static ?string $model = Pendaftaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'Pelayanan';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\MainDashboard::route('/'),
            'create' => Pages\CreateManager::route('/create'),
            'edit' => Pages\EditManager::route('/{record}/edit'),
        ];
    }
}
