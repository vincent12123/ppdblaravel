<?php

namespace App\Filament\Resources\Applicants\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ApplicantInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('registration_number'),
                TextEntry::make('name'),
                TextEntry::make('nisn'),
                TextEntry::make('birth_date')
                    ->date(),
                TextEntry::make('gender')
                    ->badge(),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('phone'),
                TextEntry::make('address')
                    ->columnSpanFull(),
                TextEntry::make('origin_school'),
                TextEntry::make('major_choice_1')
                    ->numeric(),
                TextEntry::make('major_choice_2')
                    ->numeric(),
                TextEntry::make('major_choice_3')
                    ->numeric(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('assigned_major')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('rapor_average')
                    ->numeric()
                    ->placeholder('-'),
                IconEntry::make('documents_verified')
                    ->boolean(),
                IconEntry::make('payment_verified')
                    ->boolean(),
                TextEntry::make('registered_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
