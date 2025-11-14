<?php

namespace App\Filament\Resources\Applicants\Pages;

use App\Filament\Resources\Applicants\ApplicantResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;

class ViewApplicant extends ViewRecord
{
    protected static string $resource = ApplicantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Tombol Terima Pendaftar
            Action::make('accept')
                ->label('Terima Pendaftar')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->visible(fn () => $this->record->status !== 'accepted')
                ->requiresConfirmation()
                ->form([
                    \Filament\Forms\Components\Select::make('assigned_major')
                        ->label('Jurusan yang Diterima')
                        ->options(\App\Models\Major::pluck('name', 'id'))
                        ->required()
                        ->default($this->record->major_choice_1)
                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'status' => 'accepted',
                        'assigned_major' => $data['assigned_major']
                    ]);

                    Notification::make()
                        ->title('Pendaftar Diterima')
                        ->success()
                        ->body('Pendaftar telah diterima.')
                        ->send();
                }),

            // Tombol Tolak Pendaftar
            Action::make('reject')
                ->label('Tolak Pendaftar')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn () => $this->record->status !== 'rejected' && $this->record->status !== 'accepted')
                ->requiresConfirmation()
                ->modalHeading('Tolak Pendaftar')
                ->modalDescription('Berikan alasan penolakan:')
                ->form([
                    \Filament\Forms\Components\Textarea::make('rejection_reason')
                        ->label('Alasan Penolakan')
                        ->required()
                        ->rows(3)
                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'status' => 'rejected'
                    ]);

                    // TODO: Kirim email notifikasi ke applicant

                    Notification::make()
                        ->title('Pendaftar Ditolak')
                        ->warning()
                        ->body('Status telah diupdate.')
                        ->send();
                }),

            EditAction::make()
                ->icon('heroicon-o-pencil-square'),
        ];
    }

    // Gunakan form (bukan infolist) untuk menampilkan detail, semua field otomatis disabled
    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }
}
