<?php

namespace App\Filament\Resources\Announcements\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AnnouncementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Pengumuman')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Pengumuman')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('Contoh: Pengumuman Hasil Seleksi PPDB 2025'),

                        // Field status aktif/nonaktif (is_active)
                        Toggle::make('is_active')
                            ->label('Aktif / Tampilkan di Publik')
                            ->default(true)
                            ->onColor('success')
                            ->offColor('danger')
                            ->inline(false)
                            ->helperText('Tentukan apakah pengumuman ini dapat dilihat oleh publik saat ini.'),

                        // Field tanggal publikasi
                        DateTimePicker::make('published_at')
                            ->label('Waktu Publikasi')
                            ->native(false)
                            ->displayFormat('d M Y H:i')
                            ->seconds(false)
                            ->default(now())
                            ->required()
                            ->helperText('Pengumuman akan muncul di publik sesuai waktu ini.'),

                        // Konten pengumuman menggunakan Rich Editor
                        RichEditor::make('content')
                            ->label('Isi Pengumuman')
                            ->required()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('announcement-attachments')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'h2',
                                'h3',
                                'bulletList',
                                'orderedList',
                                'blockquote',
                                'codeBlock',
                                'undo',
                                'redo',
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
