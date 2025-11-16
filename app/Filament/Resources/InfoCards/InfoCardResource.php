<?php

namespace App\Filament\Resources\InfoCards;

use App\Filament\Resources\InfoCards\Pages\CreateInfoCard;
use App\Filament\Resources\InfoCards\Pages\EditInfoCard;
use App\Filament\Resources\InfoCards\Pages\ListInfoCards;
use App\Filament\Resources\InfoCards\Schemas\InfoCardForm;
use App\Filament\Resources\InfoCards\Tables\InfoCardsTable;
use App\Models\InfoCard;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InfoCardResource extends Resource
{
    protected static ?string $model = InfoCard::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Info Cards';

    protected static ?string $modelLabel = 'Info Card';

    protected static ?string $pluralModelLabel = 'Info Cards';

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return InfoCardForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InfoCardsTable::configure($table);
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
            'index' => ListInfoCards::route('/'),
            'create' => CreateInfoCard::route('/create'),
            'edit' => EditInfoCard::route('/{record}/edit'),
        ];
    }
}
