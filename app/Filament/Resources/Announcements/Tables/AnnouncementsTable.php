<?php

namespace App\Filament\Resources\Announcements\Tables;

use App\Models\Announcement;
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
use Illuminate\Support\Str;

class AnnouncementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Pengumuman')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(50)
                    ->tooltip(fn ($record): string => $record->title ?? ''),

                TextColumn::make('content')
                    ->label('Ringkasan Konten')
                    ->formatStateUsing(fn (string $state): string => Str::limit(strip_tags($state), 60))
                    ->html()
                    ->limit(60)
                    ->toggleable(),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable()
                    ->tooltip(fn ($record): string => $record->is_active ? 'Aktif (Publik)' : 'Tidak Aktif'),

                TextColumn::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->description(fn ($record): string => $record->published_at?->diffForHumans() ?? '')
                    ->color(fn ($record): string =>
                        $record->published_at && $record->published_at->isFuture() ? 'warning' : 'success'
                    ),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filter berdasarkan status aktif/nonaktif
                SelectFilter::make('is_active')
                    ->label('Status Aktivitas')
                    ->options([
                        1 => 'Aktif',
                        0 => 'Tidak Aktif',
                    ]),

                // Filter untuk pengumuman yang sudah dipublikasi
                Filter::make('is_published')
                    ->label('Telah Dipublikasi')
                    ->query(fn (Builder $query): Builder => $query->where('published_at', '<=', now())),

                // Filter untuk pengumuman yang dijadwalkan (future)
                Filter::make('is_scheduled')
                    ->label('Dijadwalkan (Future)')
                    ->query(fn (Builder $query): Builder => $query->where('published_at', '>', now())),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    // Bulk Action: Aktifkan pengumuman terpilih
                    BulkAction::make('activate')
                        ->label('Aktifkan Pengumuman')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            $records->each(fn (Announcement $record) => $record->update(['is_active' => true]));
                        })
                        ->deselectRecordsAfterCompletion(),
                    // Bulk Action: Nonaktifkan pengumuman terpilih
                    BulkAction::make('deactivate')
                        ->label('Nonaktifkan Pengumuman')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            $records->each(fn (Announcement $record) => $record->update(['is_active' => false]));
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('published_at', 'desc');
    }
}
