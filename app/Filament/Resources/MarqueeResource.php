<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MarqueeResource\Pages;
use App\Models\Marquee;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class MarqueeResource extends Resource
{
    protected static ?string $model = Marquee::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    protected static UnitEnum|string|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 30;

    protected static ?string $navigationLabel = 'Marquee';

    protected static ?string $modelLabel = 'Marquee';

    protected static ?string $pluralModelLabel = 'Marquees';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Marquee')
                    ->schema([
                        Textarea::make('text')
                            ->label('Teks Marquee')
                            ->required()
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Maksimal 500 karakter'),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->inline(false)
                            ->helperText('Hanya marquee aktif yang ditampilkan di landing page'),

                        TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0)
                            ->helperText('Semakin kecil angka, semakin awal ditampilkan')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('text')
                    ->label('Teks')
                    ->limit(50)
                    ->searchable()
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ])
            ->defaultSort('order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMarquees::route('/'),
            'create' => Pages\CreateMarquee::route('/create'),
            'edit' => Pages\EditMarquee::route('/{record}/edit'),
        ];
    }
}
