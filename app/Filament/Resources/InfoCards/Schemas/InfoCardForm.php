<?php

namespace App\Filament\Resources\InfoCards\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InfoCardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Card')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Jadwal Pendaftaran'),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->required()
                            ->rows(3)
                            ->placeholder('Contoh: 1 Juni - 31 Juli 2025')
                            ->columnSpanFull(),
                    ])->columns(1),

                Section::make('Tampilan & Styling')
                    ->schema([
                        Select::make('icon')
                            ->label('Icon (Font Awesome)')
                            ->required()
                            ->searchable()
                            ->options([
                                'fa-calendar-alt' => '📅 Calendar (fa-calendar-alt)',
                                'fa-user-check' => '✅ User Check (fa-user-check)',
                                'fa-laptop' => '💻 Laptop (fa-laptop)',
                                'fa-clock' => '🕐 Clock (fa-clock)',
                                'fa-money-bill-wave' => '💰 Money (fa-money-bill-wave)',
                                'fa-file-alt' => '📄 File (fa-file-alt)',
                                'fa-graduation-cap' => '🎓 Graduation Cap (fa-graduation-cap)',
                                'fa-users' => '👥 Users (fa-users)',
                                'fa-check-circle' => '✔️ Check Circle (fa-check-circle)',
                                'fa-info-circle' => 'ℹ️ Info Circle (fa-info-circle)',
                                'fa-lightbulb' => '💡 Lightbulb (fa-lightbulb)',
                                'fa-star' => '⭐ Star (fa-star)',
                            ])
                            ->helperText('Pilih icon dari Font Awesome'),

                        Select::make('bg_color')
                            ->label('Warna Background')
                            ->required()
                            ->options([
                                'indigo' => '🟣 Indigo',
                                'blue' => '🔵 Blue',
                                'green' => '🟢 Green',
                                'yellow' => '🟡 Yellow',
                                'red' => '🔴 Red',
                                'purple' => '🟣 Purple',
                                'pink' => '🌸 Pink',
                                'teal' => '🔷 Teal',
                                'orange' => '🟠 Orange',
                                'gray' => '⚪ Gray',
                            ])
                            ->default('indigo'),

                        Select::make('icon_bg_color')
                            ->label('Warna Icon Background')
                            ->required()
                            ->options([
                                'indigo' => '🟣 Indigo',
                                'blue' => '🔵 Blue',
                                'green' => '🟢 Green',
                                'yellow' => '🟡 Yellow',
                                'red' => '🔴 Red',
                                'purple' => '🟣 Purple',
                                'pink' => '🌸 Pink',
                                'teal' => '🔷 Teal',
                                'orange' => '🟠 Orange',
                                'gray' => '⚪ Gray',
                            ])
                            ->default('indigo'),
                    ])->columns(3),

                Section::make('Pengaturan')
                    ->schema([
                        TextInput::make('order')
                            ->label('Urutan')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->helperText('Angka lebih kecil = tampil lebih dulu'),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Hanya card aktif yang ditampilkan'),
                    ])->columns(2),
            ]);
    }
}
