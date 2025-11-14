<?php

namespace App\Filament\Resources\Applicants\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ApplicantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Personal Pendaftar')
                    ->columns(3)
                    ->schema([
                        TextInput::make('registration_number')
                            ->label('No. Registrasi')
                            ->disabled()
                            ->dehydrated(true)
                            ->required()
                            ->maxLength(255),

                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),

                        TextInput::make('nisn')
                            ->label('NISN')
                            ->required()
                            ->numeric()
                            ->maxLength(10),

                        DatePicker::make('birth_date')
                            ->label('Tanggal Lahir')
                            ->native(false)
                            ->displayFormat('d F Y')
                            ->required()
                            ->columnSpan(1),

                        Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'male' => 'Laki-laki',
                                'female' => 'Perempuan',
                            ])
                            ->required(),

                        TextInput::make('origin_school')
                            ->label('Asal Sekolah')
                            ->maxLength(255),
                    ]),

                Section::make('Kontak & Alamat')
                    ->columns(2)
                    ->schema([
                        TextInput::make('email')
                            ->label('Email (Opsional)')
                            ->email()
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('Nomor Telepon/HP Siswa')
                            ->tel()
                            ->required()
                            ->maxLength(15),

                        TextInput::make('parent_name')
                            ->label('Nama Orang Tua/Wali')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('parent_phone')
                            ->label('Nomor HP Orang Tua/Wali')
                            ->tel()
                            ->required()
                            ->maxLength(15),

                        Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->columnSpanFull()
                            ->rows(3),
                    ]),

                Section::make('Pilihan Jurusan & Penempatan')
                    ->columns(3)
                    ->schema([
                        // Pilihan Jurusan menggunakan relasi ke Major
                        Select::make('major_choice_1')
                            ->label('Pilihan Jurusan 1')
                            ->relationship('majorChoice1', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('major_choice_2')
                            ->label('Pilihan Jurusan 2')
                            ->relationship('majorChoice2', 'name')
                            ->searchable()
                            ->preload(),

                        Select::make('major_choice_3')
                            ->label('Pilihan Jurusan 3')
                            ->relationship('majorChoice3', 'name')
                            ->searchable()
                            ->preload(),

                        Select::make('assigned_major')
                            ->label('Jurusan Diterima/Ditempatkan')
                            ->relationship('assignedMajor', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('Belum ditetapkan')
                            ->columnSpanFull(),
                    ]),

                Section::make('Status Pendaftaran')
                    ->columns(2)
                    ->schema([
                        Select::make('status')
                            ->label('Status Pendaftaran')
                            ->options([
                                'registered' => 'Terdaftar (Baru)',
                                'verified' => 'Terverifikasi',
                                'accepted' => 'Diterima (Lulus Seleksi)',
                                'rejected' => 'Ditolak',
                                'registered_final' => 'Registrasi Final',
                            ])
                            ->default('registered')
                            ->required(),

                        DateTimePicker::make('registered_at')
                            ->label('Waktu Pendaftaran')
                            ->native(false)
                            ->displayFormat('d F Y H:i')
                            ->disabled(),
                    ]),

                // Section untuk menampilkan dokumen yang diupload
                Section::make('Dokumen yang Diupload')
                    ->description('Klik "View" pada baris untuk melihat preview dokumen')
                    ->icon('heroicon-o-document-text')
                    ->collapsed()
                    ->schema([
                        \Filament\Forms\Components\Placeholder::make('documents_list')
                            ->label('')
                            ->content(function ($record) {
                                if (!$record || !$record->documents()->exists()) {
                                    return 'Belum ada dokumen yang diupload.';
                                }

                                $html = '<div class="space-y-2">';
                                foreach ($record->documents as $document) {
                                    $statusIcon = $document->is_verified
                                        ? '<span class="text-green-600">✓</span>'
                                        : '<span class="text-red-600">✗</span>';

                                    $typeLabel = match($document->type) {
                                        'foto' => 'Foto 3x4',
                                        'ijazah' => 'Ijazah/STTB',
                                        'kartu_keluarga' => 'Kartu Keluarga',
                                        'akta_kelahiran' => 'Akta Kelahiran',
                                        'rapor' => 'Rapor',
                                        default => ucfirst($document->type),
                                    };

                                    $previewUrl = asset('storage/' . $document->file_path);

                                    $html .= "<div class='flex items-center justify-between p-3 bg-gray-50 rounded-lg'>";
                                    $html .= "<div class='flex items-center gap-3'>";
                                    $html .= "{$statusIcon}";
                                    $html .= "<span class='font-medium'>{$typeLabel}</span>";
                                    $html .= "<span class='text-sm text-gray-500'>" . basename($document->file_path) . "</span>";
                                    $html .= "</div>";
                                    $html .= "<div class='flex gap-2'>";
                                    $html .= "<a href='{$previewUrl}' target='_blank' class='text-blue-600 hover:text-blue-800 text-sm'>Preview</a>";
                                    $html .= "</div>";
                                    $html .= "</div>";

                                    if ($document->verification_notes) {
                                        $html .= "<div class='ml-8 text-sm text-orange-600 italic'>";
                                        $html .= "Catatan: " . e($document->verification_notes);
                                        $html .= "</div>";
                                    }
                                }
                                $html .= '</div>';

                                return new \Illuminate\Support\HtmlString($html);
                            })
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
