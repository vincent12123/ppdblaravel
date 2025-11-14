<?php

namespace App\Filament\Resources\Documents\Pages;

use App\Filament\Resources\Documents\DocumentResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;

class ViewDocument extends ViewRecord
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Action untuk preview file
            Action::make('preview')
                ->label('Buka File')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('info')
                ->url(fn () => asset('storage/' . $this->record->file_path))
                ->openUrlInNewTab(),

            // Action untuk download file
            Action::make('download')
                ->label('Download')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->url(fn () => route('documents.download', $this->record->id))
                ->openUrlInNewTab(),

            // Action verifikasi
            Action::make('verify')
                ->label('Verifikasi Dokumen')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn () => !$this->record->is_verified)
                ->requiresConfirmation()
                ->modalHeading('Verifikasi Dokumen')
                ->modalDescription('Apakah dokumen ini valid dan sesuai?')
                ->modalSubmitActionLabel('Ya, Verifikasi')
                ->action(function () {
                    $this->record->update(['is_verified' => true]);

                    Notification::make()
                        ->title('Dokumen Terverifikasi')
                        ->success()
                        ->send();
                }),

            // Action tolak dokumen
            Action::make('reject')
                ->label('Tolak Dokumen')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->form([
                    \Filament\Forms\Components\Textarea::make('verification_notes')
                        ->label('Alasan Penolakan')
                        ->required()
                        ->rows(3)
                        ->placeholder('Contoh: Foto tidak jelas, ukuran tidak sesuai, dll.')
                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'is_verified' => false,
                        'verification_notes' => $data['verification_notes']
                    ]);

                    Notification::make()
                        ->title('Dokumen Ditolak')
                        ->warning()
                        ->body('Catatan penolakan telah disimpan.')
                        ->send();
                }),

            EditAction::make()
                ->icon('heroicon-o-pencil-square'),
        ];
    }

    // Custom view untuk menampilkan preview dokumen
    public function getContentTabLabel(): ?string
    {
        return 'Detail & Preview';
    }
}
