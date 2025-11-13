<?php

namespace App\Filament\Resources\Applicants\Schemas;

use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Schema;

class ApplicantInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // Gunakan Flex untuk split responsif dari md ke atas
            Flex::make([
                // Kiri: Profil & Data Pendaftar
                Section::make('Profil & Status')
                    ->icon('heroicon-o-user')
                    ->components([
                        Grid::make(3)->components([
                            TextEntry::make('registration_number')->label('No. Pendaftaran')->badge()->color('info'),
                            TextEntry::make('zone')->label('Jalur')->badge()->color('primary'),
                            TextEntry::make('status')->label('Status')->badge()->color('warning'),
                        ]),
                        Grid::make(3)->components([
                            TextEntry::make('name')->label('Nama Lengkap')->weight('bold')->columnSpan(2),
                        ]),

                        Tabs::make()->tabs([
                            Tab::make('Data Pribadi')
                                ->components([
                                    Grid::make(2)->components([
                                        TextEntry::make('nisn')->label('NISN'),
                                        TextEntry::make('nik')->label('NIK'),
                                        TextEntry::make('birth_place')->label('Tempat Lahir'),
                                        TextEntry::make('birth_date')->label('Tanggal Lahir')->date('d M Y'),
                                        TextEntry::make('gender')->label('Jenis Kelamin')->badge(),
                                        TextEntry::make('address')->label('Alamat Lengkap')->columnSpanFull(),
                                        TextEntry::make('coordinate')->label('Titik Koordinat'),
                                    ]),
                                ]),
                            Tab::make('Data Orang Tua / Wali')
                                ->components([
                                    TextEntry::make('parent_name')->label('Nama Orang Tua/Wali'),
                                    TextEntry::make('parent_phone')->label('No. HP Orang Tua'),
                                ]),
                            Tab::make('Data Asal Sekolah & Nilai')
                                ->components([
                                    Grid::make(2)->components([
                                        TextEntry::make('origin_school')->label('Asal Sekolah'),
                                        TextEntry::make('rapor_average')->label('Rata-rata Rapor')->numeric()->placeholder('-'),
                                        TextEntry::make('major_choice_1')->label('Pilihan 1'),
                                        TextEntry::make('major_choice_2')->label('Pilihan 2')->placeholder('-'),
                                        TextEntry::make('major_choice_3')->label('Pilihan 3')->placeholder('-'),
                                        TextEntry::make('assigned_major')->label('Diterima di')->placeholder('-'),
                                    ]),
                                ]),
                        ]),
                    ])
                    ->grow(true),

                // Kanan: Verifikasi Dokumen
                Section::make('Verifikasi Dokumen Unggahan')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->components([
                        RepeatableEntry::make('documents')
                            ->label('Dokumen')
                            ->contained(false)
                            ->columns(6)
                            ->components([
                                TextEntry::make('type')->label('# Jenis')->badge()->color('gray')->columnSpan(2),
                                TextEntry::make('file_path')->label('File')->columnSpan(3)->copyable(),
                                IconEntry::make('is_verified')->label('Valid')->boolean()->columnSpan(1),
                                TextEntry::make('verification_notes')->label('Catatan')->placeholder('-')->columnSpanFull(),
                            ]),
                        Grid::make(1)->components([
                            IconEntry::make('documents_verified')->label('Semua Dokumen Terverifikasi')->boolean(),
                            IconEntry::make('payment_verified')->label('Pembayaran Terverifikasi')->boolean(),
                        ]),
                    ])
                    ->grow(false),
            ])->from('md'),
        ]);
    }
}
