<?php

namespace App\Filament\Resources\Applicants\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ApplicantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('registration_number')
                    ->label('No. Reg.')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama Pendaftar')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(25)
                    ->tooltip(fn ($record): string => $record->name ?? ''),

                TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('gender')
                    ->label('L/P')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'male' => 'L',
                        'female' => 'P',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'male' => 'blue',
                        'female' => 'pink',
                        default => 'gray',
                    })
                    ->toggleable(),

                TextColumn::make('origin_school')
                    ->label('Asal Sekolah')
                    ->searchable()
                    ->limit(20)
                    ->toggleable(),

                TextColumn::make('majorChoice1.name')
                    ->label('Pilihan 1')
                    ->sortable()
                    ->limit(15)
                    ->tooltip(fn ($record) => $record->majorChoice1?->name),

                TextColumn::make('majorChoice2.name')
                    ->label('Pilihan 2')
                    ->limit(15)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('assignedMajor.name')
                    ->label('Jurusan Diterima')
                    ->sortable()
                    ->limit(15)
                    ->placeholder('Belum ditetapkan'),



                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'registered' => 'info',
                        'verified' => 'warning',
                        'accepted' => 'success',
                        'rejected' => 'danger',
                        'registered_final' => 'primary',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'registered' => 'Terdaftar',
                        'verified' => 'Terverifikasi',
                        'accepted' => 'Diterima',
                        'rejected' => 'Ditolak',
                        'registered_final' => 'Registrasi Final',
                        default => ucfirst($state),
                    }),



                TextColumn::make('registered_at')
                    ->label('Tgl. Daftar')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Pendaftaran')
                    ->options([
                        'registered' => 'Terdaftar',
                        'verified' => 'Terverifikasi',
                        'accepted' => 'Diterima',
                        'rejected' => 'Ditolak',
                        'registered_final' => 'Registrasi Final',
                    ])
                    ->multiple(),

                SelectFilter::make('major_choice_1')
                    ->label('Pilihan Jurusan 1')
                    ->relationship('majorChoice1', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('assigned_major')
                    ->label('Jurusan Diterima')
                    ->relationship('assignedMajor', 'name')
                    ->searchable()
                    ->preload(),

                Filter::make('documents_verified')
                    ->label('Dokumen Terverifikasi')
                    ->query(fn (Builder $query): Builder => $query->where('documents_verified', true)),

                Filter::make('payment_verified')
                    ->label('Pembayaran Terverifikasi')
                    ->query(fn (Builder $query): Builder => $query->where('payment_verified', true)),

                Filter::make('verified_all')
                    ->label('Terverifikasi Lengkap')
                    ->query(fn (Builder $query): Builder => $query->where('documents_verified', true)->where('payment_verified', true)),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('registered_at', 'desc');
    }
}
