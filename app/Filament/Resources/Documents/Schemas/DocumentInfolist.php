<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DocumentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('applicant_id')
                    ->numeric(),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('file_path'),
                IconEntry::make('is_verified')
                    ->boolean(),
                TextEntry::make('verification_notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
