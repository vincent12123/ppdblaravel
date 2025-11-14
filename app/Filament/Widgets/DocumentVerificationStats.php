<?php

namespace App\Filament\Widgets;

use App\Models\Applicant;
use App\Models\Document;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DocumentVerificationStats extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalApplicants = Applicant::count();
        $acceptedApplicants = Applicant::where('status', 'accepted')->count();
        $verifiedApplicants = Applicant::where('status', 'verified')->count();
        $registeredApplicants = Applicant::where('status', 'registered')->count();
        $rejectedApplicants = Applicant::where('status', 'rejected')->count();

        return [
            Stat::make('Total Pendaftar', $totalApplicants)
                ->description('Total calon peserta didik')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary')
                ->chart([7, 12, 15, 18, 22, 25, $totalApplicants]),

            Stat::make('Pendaftar Diterima', $acceptedApplicants)
                ->description("{$verifiedApplicants} terverifikasi, {$registeredApplicants} baru daftar")
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success')
                ->chart([2, 5, 8, 12, 15, 18, $acceptedApplicants]),

            Stat::make('Pendaftar Ditolak', $rejectedApplicants)
                ->description('Tidak memenuhi persyaratan')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color('danger')
                ->chart([0, 1, 1, 2, 3, 4, $rejectedApplicants]),
        ];
    }
}
