<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class DocumentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dokumen')
                    ->icon('heroicon-o-document-text')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('applicant.name')
                            ->label('Nama Pendaftar')
                            ->weight('bold')
                            ->icon('heroicon-o-user')
                            ->color('primary'),

                        TextEntry::make('applicant.registration_number')
                            ->label('No. Registrasi')
                            ->badge()
                            ->color('info')
                            ->icon('heroicon-o-identification'),

                        TextEntry::make('type')
                            ->label('Jenis Dokumen')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'foto' => 'info',
                                'ijazah', 'rapor' => 'warning',
                                'kartu_keluarga', 'akta_kelahiran' => 'primary',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'foto' => 'Foto 3x4',
                                'ijazah' => 'Ijazah/STTB',
                                'kartu_keluarga' => 'Kartu Keluarga',
                                'akta_kelahiran' => 'Akta Kelahiran',
                                'rapor' => 'Rapor',
                                default => $state,
                            }),

                        TextEntry::make('file_path')
                            ->label('Nama File')
                            ->formatStateUsing(fn (string $state): string => basename($state))
                            ->copyable()
                            ->icon('heroicon-o-document'),

                        IconEntry::make('is_verified')
                            ->label('Status Verifikasi')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),

                        TextEntry::make('created_at')
                            ->label('Diunggah Pada')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-o-clock'),
                    ]),

                Section::make('Preview Dokumen')
                    ->icon('heroicon-o-photo')
                    ->description('Preview file yang diupload')
                    ->schema([
                        ImageEntry::make('file_path')
                            ->label('')
                            ->disk('public')
                            ->height(400)
                            ->visible(fn ($record) => Str::contains($record->file_path, ['.jpg', '.jpeg', '.png', '.gif', '.webp']))
                            ->extraAttributes(['class' => 'rounded-lg shadow-lg']),

                        TextEntry::make('file_path')
                            ->label('File PDF')
                            ->visible(fn ($record) => Str::contains($record->file_path, '.pdf'))
                            ->formatStateUsing(fn () => 'File PDF - Klik tombol "Buka File" di atas untuk melihat')
                            ->icon('heroicon-o-document-text')
                            ->color('warning'),
                    ]),

                Section::make('Catatan Verifikasi')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->visible(fn ($record) => !empty($record->verification_notes))
                    ->schema([
                        TextEntry::make('verification_notes')
                            ->label('')
                            ->columnSpanFull()
                            ->markdown(),
                    ]),
            ]);
    }
}
