@extends('landing.layout')

@section('title', 'Status Pendaftaran - PPDB Online SMK')

@section('content')

<!-- Page Header -->
<section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold mb-2">Status Pendaftaran</h1>
        <p class="text-lg text-indigo-100">{{ $applicant->registration_number }}</p>
    </div>
</section>

<!-- Status Content -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">

            <!-- Status Badge -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-6 text-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Status Pendaftaran</h2>
                @php
                    $statusConfig = [
                        'draft' => ['color' => 'gray', 'icon' => 'fa-file-alt', 'text' => 'Draft'],
                        'submitted' => ['color' => 'blue', 'icon' => 'fa-paper-plane', 'text' => 'Menunggu Verifikasi'],
                        'reviewed' => ['color' => 'yellow', 'icon' => 'fa-eye', 'text' => 'Sedang Ditinjau'],
                        'accepted' => ['color' => 'green', 'icon' => 'fa-check-circle', 'text' => 'Diterima'],
                        'rejected' => ['color' => 'red', 'icon' => 'fa-times-circle', 'text' => 'Ditolak']
                    ];
                    $status = $statusConfig[$applicant->status] ?? $statusConfig['submitted'];
                @endphp

                <div class="inline-block">
                    <div class="px-8 py-4 bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-800 rounded-full text-xl font-bold">
                        <i class="fas {{ $status['icon'] }} mr-2"></i>
                        {{ $status['text'] }}
                    </div>
                </div>

                @if($applicant->status === 'accepted' && $applicant->assignedMajor)
                <div class="mt-6 p-6 bg-green-50 border-2 border-green-200 rounded-xl">
                    <p class="text-lg text-gray-700 mb-2">Selamat! Anda diterima di jurusan:</p>
                    <p class="text-2xl font-bold text-green-700">{{ $applicant->assignedMajor->name }}</p>
                </div>
                @endif

                @if($applicant->status === 'rejected')
                <div class="mt-6 p-6 bg-red-50 border-2 border-red-200 rounded-xl">
                    <p class="text-lg text-gray-700">Maaf, pendaftaran Anda belum dapat kami terima pada periode ini.</p>
                    <p class="text-sm text-gray-600 mt-2">Silakan hubungi panitia untuk informasi lebih lanjut.</p>
                </div>
                @endif
            </div>

            <!-- Applicant Data -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-user text-indigo-600 mr-3"></i>
                    Data Pribadi
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Nama Lengkap</p>
                        <p class="font-semibold text-gray-800">{{ $applicant->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm mb-1">NISN</p>
                        <p class="font-semibold text-gray-800">{{ $applicant->nisn }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Tanggal Lahir</p>
                        <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($applicant->birth_date)->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Jenis Kelamin</p>
                        <p class="font-semibold text-gray-800">{{ $applicant->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Email</p>
                        <p class="font-semibold text-gray-800">{{ $applicant->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm mb-1">No. HP</p>
                        <p class="font-semibold text-gray-800">{{ $applicant->phone }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Asal Sekolah</p>
                        <p class="font-semibold text-gray-800">{{ $applicant->origin_school }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm mb-1">Tanggal Daftar</p>
                        <p class="font-semibold text-gray-800">{{ $applicant->registered_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Major Choices -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-graduation-cap text-indigo-600 mr-3"></i>
                    Pilihan Jurusan
                </h3>
                <div class="space-y-4">
                    @if($applicant->majorChoice1)
                    <div class="flex items-center p-4 bg-indigo-50 rounded-lg">
                        <span class="bg-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold mr-4">1</span>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $applicant->majorChoice1->name }}</p>
                            <p class="text-sm text-gray-600">{{ $applicant->majorChoice1->description }}</p>
                        </div>
                    </div>
                    @endif

                    @if($applicant->majorChoice2)
                    <div class="flex items-center p-4 bg-purple-50 rounded-lg">
                        <span class="bg-purple-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold mr-4">2</span>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $applicant->majorChoice2->name }}</p>
                            <p class="text-sm text-gray-600">{{ $applicant->majorChoice2->description }}</p>
                        </div>
                    </div>
                    @endif

                    @if($applicant->majorChoice3)
                    <div class="flex items-center p-4 bg-pink-50 rounded-lg">
                        <span class="bg-pink-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold mr-4">3</span>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $applicant->majorChoice3->name }}</p>
                            <p class="text-sm text-gray-600">{{ $applicant->majorChoice3->description }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Documents Status -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-file-alt text-indigo-600 mr-3"></i>
                    Status Dokumen
                </h3>

                @php
                    $documentTypes = [
                        'foto' => ['name' => 'Pas Foto 3x4', 'icon' => 'fa-image'],
                        'ijazah' => ['name' => 'Ijazah/STTB SMP', 'icon' => 'fa-certificate'],
                        'kartu_keluarga' => ['name' => 'Kartu Keluarga', 'icon' => 'fa-users'],
                        'akta_kelahiran' => ['name' => 'Akta Kelahiran', 'icon' => 'fa-file-alt'],
                        'rapor' => ['name' => 'Rapor Semester 1-5', 'icon' => 'fa-book']
                    ];
                @endphp

                <div class="space-y-3">
                    @foreach($documentTypes as $type => $info)
                        @php
                            $document = $applicant->documents->firstWhere('type', $type);
                        @endphp
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas {{ $info['icon'] }} text-gray-400 mr-3"></i>
                                <span class="text-gray-800">{{ $info['name'] }}</span>
                            </div>
                            @if($document)
                                @if($document->is_verified)
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                    <i class="fas fa-check-circle mr-1"></i>Terverifikasi
                                </span>
                                @else
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
                                    <i class="fas fa-clock mr-1"></i>Menunggu Verifikasi
                                </span>
                                @endif
                            @else
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">
                                <i class="fas fa-minus-circle mr-1"></i>Tidak Ada
                            </span>
                            @endif
                        </div>
                    @endforeach
                </div>

                @php
                    $totalDocs = $applicant->documents->count();
                    $verifiedDocs = $applicant->documents->where('is_verified', true)->count();
                @endphp

                @if($totalDocs > 0)
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-700 font-semibold">Progress Verifikasi</span>
                        <span class="text-gray-800 font-bold">{{ $verifiedDocs }}/{{ $totalDocs }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-indigo-600 h-3 rounded-full transition-all" style="width: {{ $totalDocs > 0 ? ($verifiedDocs/$totalDocs*100) : 0 }}%"></div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Next Steps -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-clipboard-list text-indigo-600 mr-3"></i>
                    Langkah Selanjutnya
                </h3>

                @if($applicant->status === 'submitted')
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                    <ul class="list-disc list-inside space-y-2 text-gray-700">
                        <li>Tim kami sedang memverifikasi dokumen Anda</li>
                        <li>Proses verifikasi memakan waktu <strong>2-3 hari kerja</strong></li>
                        <li>Anda akan menerima notifikasi melalui email</li>
                        <li>Pantau status pendaftaran secara berkala</li>
                    </ul>
                </div>
                @elseif($applicant->status === 'reviewed')
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4">
                    <ul class="list-disc list-inside space-y-2 text-gray-700">
                        <li>Dokumen Anda sedang dalam tahap peninjauan akhir</li>
                        <li>Harap bersabar menunggu pengumuman</li>
                        <li>Pastikan email dan nomor HP Anda aktif</li>
                    </ul>
                </div>
                @elseif($applicant->status === 'accepted')
                <div class="bg-green-50 border-l-4 border-green-500 p-4">
                    <ul class="list-disc list-inside space-y-2 text-gray-700">
                        <li>Selamat! Pendaftaran Anda telah <strong>diterima</strong></li>
                        <li>Silakan cek email untuk informasi daftar ulang</li>
                        <li>Siapkan dokumen asli untuk verifikasi</li>
                        <li>Lakukan daftar ulang sesuai jadwal yang ditentukan</li>
                    </ul>
                </div>
                @elseif($applicant->status === 'rejected')
                <div class="bg-red-50 border-l-4 border-red-500 p-4">
                    <ul class="list-disc list-inside space-y-2 text-gray-700">
                        <li>Maaf, pendaftaran Anda belum dapat kami terima</li>
                        <li>Silakan hubungi panitia untuk penjelasan lebih detail</li>
                        <li>Anda dapat mencoba mendaftar di periode berikutnya</li>
                    </ul>
                </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <button onclick="window.print()"
                    class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                    <i class="fas fa-print mr-2"></i>Cetak Status
                </button>
                <a href="{{ route('registration.checkStatus') }}"
                    class="bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition text-center">
                    <i class="fas fa-sync mr-2"></i>Cek Status Lagi
                </a>
                <a href="{{ route('landing') }}"
                    class="bg-gray-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-700 transition text-center">
                    <i class="fas fa-home mr-2"></i>Beranda
                </a>
            </div>

        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    @media print {
        button, a[href*="registration.checkStatus"], a[href*="landing"] {
            display: none !important;
        }
    }
</style>
@endpush
