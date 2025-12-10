<?php

namespace App\Filament\App\Resources\Units;

use App\Filament\App\Resources\Units\Pages\CreateUnit;
use App\Filament\App\Resources\Units\Pages\EditUnit;
use App\Filament\App\Resources\Units\Pages\ListUnits;
use App\Filament\App\Resources\Units\Pages\ViewUnit;
use App\Filament\App\Resources\Units\Schemas\UnitForm;
use App\Filament\App\Resources\Units\Schemas\UnitInfolist;
use App\Filament\App\Resources\Units\Tables\UnitsTable;
use App\Models\Unit;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static ?string $recordTitleAttribute = 'number';

    // Labels em português
    protected static ?string $modelLabel = 'Unidade';
    protected static ?string $pluralModelLabel = 'Unidades';
    protected static ?string $navigationLabel = 'Unidades';
    protected static UnitEnum|string|null $navigationGroup = 'Cadastros';

    // Oculto do menu - gerenciado via RelationManager em Development
    protected static bool $shouldRegisterNavigation = false;

    // Desabilita tenant scoping - Units são acessadas via RelationManager que já herda o escopo
    protected static bool $isScopedToTenant = false;

    public static function form(Schema $schema): Schema
    {
        return UnitForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UnitInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UnitsTable::configure($table);
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
            'index' => ListUnits::route('/'),
            'create' => CreateUnit::route('/create'),
            'view' => ViewUnit::route('/{record}'),
            'edit' => EditUnit::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
