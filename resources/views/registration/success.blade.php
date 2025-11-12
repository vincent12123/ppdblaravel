@extends('landing.layout')

@section('title', 'Pendaftaran Berhasil - PPDB Online SMK')

@section('content')

<section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 to-purple-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">

            <!-- Success Card -->
            <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12 text-center">

                <!-- Success Icon -->
                <div class="mb-6">
                    <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                        <i class="fas fa-check-circle text-5xl text-green-500"></i>
                    </div>
                </div>

                <!-- Success Message -->
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    Pendaftaran Berhasil!
                </h1>

                <p class="text-lg text-gray-600 mb-8">
                    Selamat! Pendaftaran Anda telah berhasil disimpan.
                </p>

                <!-- Registration Number Box -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl p-6 mb-8">
                    <p class="text-sm font-semibold mb-2 opacity-90">Nomor Pendaftaran Anda</p>
                    <div class="text-4xl font-bold tracking-wider mb-2">
                        {{ $applicant->registration_number }}
                    </div>
                    <p class="text-sm opacity-90">Simpan nomor ini untuk melacak status pendaftaran</p>
                </div>

                <!-- Applicant Info -->
                <div class="bg-gray-50 rounded-xl p-6 mb-8 text-left">
                    <h3 class="font-bold text-gray-800 mb-4 text-center">Informasi Pendaftar</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nama Lengkap:</span>
                            <span class="font-semibold text-gray-800">{{ $applicant->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">NISN:</span>
                            <span class="font-semibold text-gray-800">{{ $applicant->nisn }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email:</span>
                            <span class="font-semibold text-gray-800">{{ $applicant->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal Daftar:</span>
                            <span class="font-semibold text-gray-800">{{ $applicant->registered_at->format('d F Y, H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                Menunggu Verifikasi
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 mb-8 text-left">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-info-circle text-yellow-500 mr-2"></i>
                        Langkah Selanjutnya
                    </h3>
                    <ol class="list-decimal list-inside space-y-2 text-gray-700">
                        <li>Simpan nomor pendaftaran Anda dengan baik</li>
                        <li>Tim kami akan memverifikasi dokumen dalam <strong>2-3 hari kerja</strong></li>
                        <li>Anda akan menerima notifikasi melalui email yang terdaftar</li>
                        <li>Pantau status pendaftaran secara berkala</li>
                        <li>Pengumuman hasil seleksi akan diumumkan sesuai jadwal</li>
                    </ol>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col md:flex-row gap-4 justify-center">
                    <button onclick="window.print()"
                        class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        <i class="fas fa-print mr-2"></i>Cetak Bukti Pendaftaran
                    </button>
                    <a href="{{ route('registration.checkStatus') }}"
                        class="bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition text-center">
                        <i class="fas fa-search mr-2"></i>Cek Status Pendaftaran
                    </a>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('landing') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                        <i class="fas fa-home mr-2"></i>Kembali ke Beranda
                    </a>
                </div>

            </div>

        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    @media print {
        .bg-gradient-to-br {
            background: white !important;
        }
        button, a[href*="landing"] {
            display: none !important;
        }
    }
</style>
@endpush
