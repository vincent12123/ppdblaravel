<?php

namespace App\Exports;

use App\Models\Applicant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ApplicantsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $status;

    public function __construct($status = null)
    {
        $this->status = $status;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Applicant::with(['majorChoice1', 'majorChoice2', 'majorChoice3', 'assignedMajor']);

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $query->orderBy('registered_at', 'desc')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No. Registrasi',
            'Nama Lengkap',
            'NISN',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Email',
            'No. HP',
            'Nama Orang Tua/Wali',
            'No. HP Orang Tua',
            'Alamat',
            'Asal Sekolah',
            'Pilihan Jurusan 1',
            'Pilihan Jurusan 2',
            'Pilihan Jurusan 3',
            'Jurusan Diterima',
            'Status',
            'Tanggal Daftar',
        ];
    }

    /**
     * @param mixed $applicant
     * @return array
     */
    public function map($applicant): array
    {
        return [
            $applicant->registration_number,
            $applicant->name,
            $applicant->nisn,
            $applicant->birth_place,
            $applicant->birth_date?->format('d/m/Y'),
            $applicant->gender === 'male' ? 'Laki-laki' : 'Perempuan',
            $applicant->email ?? '-',
            $applicant->phone,
            $applicant->parent_name,
            $applicant->parent_phone,
            $applicant->address,
            $applicant->origin_school,
            $applicant->majorChoice1?->name ?? '-',
            $applicant->majorChoice2?->name ?? '-',
            $applicant->majorChoice3?->name ?? '-',
            $applicant->assignedMajor?->name ?? '-',
            $this->getStatusLabel($applicant->status),
            $applicant->registered_at?->format('d/m/Y H:i'),
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5']
                ],
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ]
            ],
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 20, // No. Registrasi
            'B' => 25, // Nama Lengkap
            'C' => 15, // NISN
            'D' => 20, // Tempat Lahir
            'E' => 15, // Tanggal Lahir
            'F' => 15, // Jenis Kelamin
            'G' => 25, // Email
            'H' => 15, // No. HP
            'I' => 25, // Nama Orang Tua
            'J' => 15, // No. HP Orang Tua
            'K' => 35, // Alamat
            'L' => 30, // Asal Sekolah
            'M' => 25, // Pilihan Jurusan 1
            'N' => 25, // Pilihan Jurusan 2
            'O' => 25, // Pilihan Jurusan 3
            'P' => 25, // Jurusan Diterima
            'Q' => 15, // Status
            'R' => 20, // Tanggal Daftar
        ];
    }

    /**
     * Get status label in Indonesian
     */
    private function getStatusLabel($status): string
    {
        return match($status) {
            'registered' => 'Terdaftar',
            'verified' => 'Terverifikasi',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            'registered_final' => 'Daftar Ulang',
            default => $status,
        };
    }
}
