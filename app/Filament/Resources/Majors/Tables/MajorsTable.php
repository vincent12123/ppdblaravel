<?php

namespace App\Filament\Resources\Majors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use App\Filament\Resources\MajorResource\Actions\EmailCustomerAction; // Contoh custom action
use Filament\Tables\Columns\Summarizers\Summarizer; // Untuk summary

class MajorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('icon')->square()->width(40),
                TextColumn::make('name')
                    ->label('Nama Jurusan')
                    ->searchable() // Memungkinkan pencarian pada kolom ini [18]
                    ->sortable(), // Memungkinkan sorting [19]

                TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan secara default

                TextColumn::make('quota')
                    ->label('Kuota')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('applicants_count')
                    ->label('Jumlah Pendaftar')
                    ->counts('applicants') // Mengambil count dari relasi applicants() [20]
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Kita bisa menambahkan QueryBuilder untuk filtering kompleks [21]
            ])
            ->recordActions([
                // Action tingkat baris
                EditAction::make(), // Aksi edit bawaan [22]
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\DeleteAction::make(), // Aksi hapus per baris [23]
            ])
            ->toolbarActions([
                // Action di toolbar, seperti Create [22]
                \Filament\Actions\CreateAction::make(),
            ])
            ->bulkActions([
                // Aksi yang berjalan pada banyak rekor yang dipilih [24]
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ])
            ])
            ->defaultSort('name');
    }
}
