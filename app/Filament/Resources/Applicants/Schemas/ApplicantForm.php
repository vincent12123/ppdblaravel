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
                            ->label('Email')
                            ->email()
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('Nomor Telepon/HP')
                            ->tel()
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

                        TextInput::make('rapor_average')
                            ->label('Rata-rata Rapor')
                            ->numeric()
                            ->step(0.01)
                            ->placeholder('Contoh: 85.5'),
                    ]),

                Section::make('Status Verifikasi & Pendaftaran')
                    ->columns(3)
                    ->schema([
                        Toggle::make('documents_verified')
                            ->label('Dokumen Terverifikasi')
                            ->onColor('success')
                            ->offColor('danger')
                            ->inline(false)
                            ->helperText('Status verifikasi kelengkapan dokumen pendaftar.'),

                        Toggle::make('payment_verified')
                            ->label('Pembayaran Terverifikasi')
                            ->onColor('success')
                            ->offColor('danger')
                            ->inline(false)
                            ->helperText('Status verifikasi pembayaran pendaftaran.'),

                        Select::make('status')
                            ->label('Status Pendaftaran')
                            ->options([
                                'draft' => 'Draft',
                                'submitted' => 'Telah Mendaftar',
                                'reviewed' => 'Sedang Direview',
                                'accepted' => 'Diterima (Lulus Seleksi)',
                                'rejected' => 'Ditolak',
                            ])
                            ->default('submitted')
                            ->required(),

                        DateTimePicker::make('registered_at')
                            ->label('Waktu Pendaftaran')
                            ->native(false)
                            ->displayFormat('d F Y H:i')
                            ->disabled()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
