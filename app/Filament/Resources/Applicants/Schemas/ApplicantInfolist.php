<?php

namespace App\Filament\Resources\Applicants\Schemas;

use Filament\Schemas\Schema;

// Layout components (Schemas v4)
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

// Infolist entries
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;

class ApplicantInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Menjadikan layout lebih lebar dengan menggunakan multiple columns
                Grid::make()
                    ->columns(['default' => 1, 'md' => 2, 'xl' => 3]) // 1 kolom mobile, 2 kolom tablet, 3 kolom desktop
                    ->schema([
                        // ================== KIRI (Profil & Status) ==================
                        Section::make('Profil & Status')
                            ->icon('heroicon-o-user')
                            ->columnSpan(['default' => 1, 'md' => 2, 'xl' => 3]) // Span semua kolom yang tersedia
                            ->schema([
                                // Baris: No Pendaftaran, Jalur, Status
                                Grid::make([
                                    'default' => 1,
                                    'md'      => 3, // 3 kolom untuk tampilan lebih lebar
                                ])->schema([
                                    TextEntry::make('registration_number')
                                        ->label('No. Pendaftaran')
                                        ->badge()
                                        ->color('info'),



                                    TextEntry::make('status')
                                        ->label('Status')
                                        ->badge()
                                        ->color('warning'),
                                ]),

                                // Baris: Nama
                                Grid::make([
                                    'default' => 1,
                                    'md'      => 1,
                                ])->schema([
                                    TextEntry::make('name')
                                        ->label('Nama Lengkap')
                                        ->weight('bold')
                                        ->columnSpanFull(),
                                ]),

                                // Tabs data pendaftar
                                Tabs::make('Data Pendaftar')
                                    ->tabs([
                                        Tab::make('Data Pribadi')
                                            ->schema([
                                                Grid::make([
                                                    'default' => 1,
                                                    'md'      => 2, // 2 kolom untuk tampilan lebih lebar
                                                ])->schema([
                                                    TextEntry::make('nisn')
                                                        ->label('NISN'),
                                                    TextEntry::make('nik')
                                                        ->label('NIK'),
                                                    TextEntry::make('birth_date')
                                                        ->label('Tanggal Lahir')
                                                        ->date('d M Y'),
                                                    TextEntry::make('gender')
                                                        ->label('Jenis Kelamin')
                                                        ->badge(),
                                                    TextEntry::make('address')
                                                        ->label('Alamat Lengkap')
                                                        ->columnSpanFull(),

                                                ]),
                                            ]),

                                        Tab::make('Data Orang Tua / Wali')
                                            ->schema([
                                                Grid::make([
                                                    'default' => 1,
                                                    'md'      => 2, // 2 kolom untuk tampilan lebih lebar
                                                ])->schema([
                                                    TextEntry::make('parent_name')
                                                        ->label('Nama Orang Tua/Wali'),
                                                    TextEntry::make('parent_phone')
                                                        ->label('No. HP Orang Tua'),
                                                ]),
                                            ]),

                                        Tab::make('Asal Sekolah & Pilihan Jurusan')
                                            ->schema([
                                                Grid::make([
                                                    'default' => 1,
                                                    'md'      => 2, // 2 kolom untuk tampilan lebih lebar
                                                ])->schema([
                                                    TextEntry::make('origin_school')
                                                        ->label('Asal Sekolah'),

                                                    TextEntry::make('majorChoice1.name')
                                                        ->label('Pilihan 1')
                                                        ->placeholder('-'),

                                                    TextEntry::make('majorChoice2.name')
                                                        ->label('Pilihan 2')
                                                        ->placeholder('-'),

                                                    TextEntry::make('majorChoice3.name')
                                                        ->label('Pilihan 3')
                                                        ->placeholder('-'),

                                                    TextEntry::make('assignedMajor.name')
                                                        ->label('Diterima di')
                                                        ->placeholder('-')
                                                        ->badge()
                                                        ->color('success'),
                                                ]),
                                            ]),


                                    ]),
                            ]),
                    ]),
            ]);
    }
}
