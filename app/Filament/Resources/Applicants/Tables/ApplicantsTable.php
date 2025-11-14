<?php

namespace App\Filament\Resources\Applicants\Tables;

use App\Exports\ApplicantsExport;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Facades\Excel;

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
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('export')
                        ->label('Export Selected')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('success')
                        ->action(function (Collection $records) {
                            $filename = 'data-pendaftar-selected-' . now()->format('Y-m-d-His') . '.xlsx';

                            return Excel::download(
                                new class($records) extends ApplicantsExport {
                                    private $records;

                                    public function __construct($records)
                                    {
                                        parent::__construct();
                                        $this->records = $records;
                                    }

                                    public function collection()
                                    {
                                        return $this->records;
                                    }
                                },
                                $filename
                            );
                        })
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('registered_at', 'desc');
    }
}
