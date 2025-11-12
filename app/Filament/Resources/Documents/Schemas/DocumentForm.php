<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dasar Dokumen')
                    ->columns(3)
                    ->schema([
                        // Field Pendaftar (BelongsTo Applicant)
                        Select::make('applicant_id')
                            ->label('Pendaftar')
                            ->relationship('applicant', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan(2),

                        Select::make('type')
                            ->label('Jenis Dokumen')
                            ->options([
                                'foto' => 'Foto 3x4',
                                'ijazah' => 'Ijazah/STTB',
                                'kartu_keluarga' => 'Kartu Keluarga',
                                'akta_kelahiran' => 'Akta Kelahiran',
                                'rapor' => 'Rapor (Semester Terakhir)',
                                'surat_pernyataan' => 'Surat Pernyataan',
                                'surat_rekomendasi' => 'Surat Rekomendasi',
                                'lainnya' => 'Lainnya',
                            ])
                            ->required()
                            ->columnSpan(1),

                        // Field File Upload
                        FileUpload::make('file_path')
                            ->label('File Dokumen')
                            ->disk('public')
                            ->directory('ppdb_documents')
                            ->openable()
                            ->downloadable()
                            ->acceptedFileTypes(['application/pdf', 'image/*'])
                            ->maxSize(5120) // 5MB
                            ->helperText('Format: PDF atau Gambar (Max 5MB)')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Status Verifikasi')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_verified')
                            ->label('Dokumen Terverifikasi')
                            ->onColor('success')
                            ->offColor('danger')
                            ->inline(false)
                            ->helperText('Centang jika dokumen telah diverifikasi dan sesuai.'),

                        Textarea::make('verification_notes')
                            ->label('Catatan Verifikasi')
                            ->placeholder('Masukkan catatan jika ada ketidaksesuaian atau informasi tambahan.')
                            ->autosize()
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
