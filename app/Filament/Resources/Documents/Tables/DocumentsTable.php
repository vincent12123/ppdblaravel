<?php

namespace App\Filament\Resources\Documents\Tables;

use App\Models\Document;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class DocumentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom untuk menampilkan nama Pendaftar (menggunakan dot notation)
                TextColumn::make('applicant.name')
                    ->label('Pendaftar')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(25)
                    ->tooltip(fn ($record) => $record->applicant?->name),

                TextColumn::make('applicant.registration_number')
                    ->label('No. Reg.')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('type')
                    ->label('Jenis Dokumen')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'foto' => 'info',
                        'ijazah', 'rapor' => 'warning',
                        'kartu_keluarga', 'akta_kelahiran' => 'primary',
                        'surat_pernyataan', 'surat_rekomendasi' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'foto' => 'Foto 3x4',
                        'ijazah' => 'Ijazah/STTB',
                        'kartu_keluarga' => 'Kartu Keluarga',
                        'akta_kelahiran' => 'Akta Kelahiran',
                        'rapor' => 'Rapor',
                        'surat_pernyataan' => 'Surat Pernyataan',
                        'surat_rekomendasi' => 'Surat Rekomendasi',
                        'lainnya' => 'Lainnya',
                        default => $state,
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('file_path')
                    ->label('File')
                    ->formatStateUsing(fn (string $state): string => basename($state))
                    ->limit(20)
                    ->tooltip(fn (string $state): string => basename($state))
                    ->toggleable(),

                IconColumn::make('is_verified')
                    ->label('Terverifikasi')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                TextColumn::make('verification_notes')
                    ->label('Catatan')
                    ->limit(30)
                    ->tooltip(fn ($record): ?string => $record->verification_notes)
                    ->placeholder('Tidak ada catatan')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Diunggah')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filter berdasarkan status verifikasi
                Filter::make('verified')
                    ->label('Dokumen Terverifikasi')
                    ->query(fn (Builder $query): Builder => $query->where('is_verified', true)),

                Filter::make('unverified')
                    ->label('Belum Terverifikasi')
                    ->query(fn (Builder $query): Builder => $query->where('is_verified', false)),

                // Filter berdasarkan jenis dokumen
                SelectFilter::make('type')
                    ->label('Jenis Dokumen')
                    ->options([
                        'foto' => 'Foto 3x4',
                        'ijazah' => 'Ijazah/STTB',
                        'kartu_keluarga' => 'Kartu Keluarga',
                        'akta_kelahiran' => 'Akta Kelahiran',
                        'rapor' => 'Rapor',
                        'surat_pernyataan' => 'Surat Pernyataan',
                        'surat_rekomendasi' => 'Surat Rekomendasi',
                        'lainnya' => 'Lainnya',
                    ]),

                // Filter berdasarkan Pendaftar (Relasi)
                SelectFilter::make('applicant_id')
                    ->label('Filter Berdasarkan Pendaftar')
                    ->relationship('applicant', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                // Action untuk preview/download file
                \Filament\Tables\Actions\Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn (Document $record): string => asset('storage/' . $record->file_path))
                    ->openUrlInNewTab(),

                \Filament\Tables\Actions\Action::make('verify')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Document $record): bool => !$record->is_verified)
                    ->requiresConfirmation()
                    ->action(fn (Document $record) => $record->update(['is_verified' => true])),

                \Filament\Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Document $record): bool => $record->is_verified)
                    ->form([
                        \Filament\Forms\Components\Textarea::make('verification_notes')
                            ->label('Catatan Penolakan')
                            ->required()
                            ->rows(3)
                    ])
                    ->action(function (Document $record, array $data) {
                        $record->update([
                            'is_verified' => false,
                            'verification_notes' => $data['verification_notes']
                        ]);
                    }),

                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    // Aksi Massal: Verifikasi Dokumen Terpilih
                    BulkAction::make('verify_documents')
                        ->label('Verifikasi Dokumen Terpilih')
                        ->requiresConfirmation()
                        ->color('success')
                        ->icon('heroicon-o-check-circle')
                        ->action(function (Collection $records): void {
                            $records->each(fn (Document $record) => $record->update(['is_verified' => true]));
                        })
                        ->deselectRecordsAfterCompletion(),
                    // Aksi Massal: Batalkan Verifikasi
                    BulkAction::make('unverify_documents')
                        ->label('Batalkan Verifikasi')
                        ->requiresConfirmation()
                        ->color('warning')
                        ->icon('heroicon-o-x-circle')
                        ->action(function (Collection $records): void {
                            $records->each(fn (Document $record) => $record->update(['is_verified' => false]));
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
