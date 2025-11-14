<?php

namespace App\Filament\Resources\Announcements\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AnnouncementInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title')
                    ->label('Judul')
                    ->weight('bold')
                    ->size('lg'),

                TextEntry::make('content')
                    ->label('Konten')
                    ->html()
                    ->columnSpanFull(),

                IconEntry::make('is_active')
                    ->label('Status Aktif')
                    ->boolean(),

                TextEntry::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->dateTime('d F Y, H:i')
                    ->placeholder('-'),

                TextEntry::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d F Y, H:i')
                    ->placeholder('-'),

                TextEntry::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime('d F Y, H:i')
                    ->placeholder('-'),
            ]);
    }
}
