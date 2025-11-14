<?php

namespace App\Filament\Resources\Applicants\Pages;

use App\Filament\Resources\Applicants\ApplicantResource;
use App\Exports\ApplicantsExport;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListApplicants extends ListRecords
{
    protected static string $resource = ApplicantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export')
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    $status = $this->activeTab !== 'all' ? $this->activeTab : null;

                    $filename = 'data-pendaftar';
                    if ($status) {
                        $filename .= '-' . $status;
                    }
                    $filename .= '-' . now()->format('Y-m-d-His') . '.xlsx';

                    return Excel::download(new ApplicantsExport($status), $filename);
                }),
            CreateAction::make(),
        ];
    }
}
