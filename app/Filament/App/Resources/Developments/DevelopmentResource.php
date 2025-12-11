<?php

namespace App\Filament\App\Resources\Developments;

use App\Filament\App\Resources\Developments\Pages\CreateDevelopment;
use App\Filament\App\Resources\Developments\Pages\EditDevelopment;
use App\Filament\App\Resources\Developments\Pages\ListDevelopments;
use App\Filament\App\Resources\Developments\Pages\ViewDevelopment;
use App\Filament\App\Resources\Developments\Schemas\DevelopmentForm;
use App\Filament\App\Resources\Developments\Schemas\DevelopmentInfolist;
use App\Filament\App\Resources\Developments\Tables\DevelopmentsTable;
use App\Filament\App\Resources\Developments\RelationManagers\UnitsRelationManager;
use App\Filament\App\Resources\Developments\RelationManagers\AdjustmentsRelationManager;
use App\Models\Development;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DevelopmentResource extends Resource
{
    protected static ?string $model = Development::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static ?string $recordTitleAttribute = 'name';

    // Labels em português
    protected static ?string $modelLabel = 'Empreendimento';
    protected static ?string $pluralModelLabel = 'Empreendimentos';
    protected static ?string $navigationLabel = 'Empreendimentos';
    protected static UnitEnum|string|null $navigationGroup = 'Cadastros';

    public static function form(Schema $schema): Schema
    {
        return DevelopmentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DevelopmentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DevelopmentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            UnitsRelationManager::class,
            AdjustmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDevelopments::route('/'),
            'create' => CreateDevelopment::route('/create'),
            'view' => ViewDevelopment::route('/{record}'),
            'edit' => EditDevelopment::route('/{record}/edit'),
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
