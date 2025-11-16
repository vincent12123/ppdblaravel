@extends('landing.layout')

@section('title', 'Beranda - PPDB Online SMK')

@section('content')

<!-- Hero Section -->
<section class="hero-gradient text-white py-20 animate-fade-in">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">
                Selamat Datang di PPDB Online
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-indigo-100">
                Wujudkan Impianmu! Daftar Sekarang dan Raih Masa Depan Cemerlang Bersama Kami
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#jurusan" class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition transform hover:scale-105">
                    <i class="fas fa-graduation-cap mr-2"></i>Lihat Jurusan
                </a>
                <a href="#alur-pendaftaran" class="bg-indigo-500 text-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-indigo-600 transition transform hover:scale-105 border-2 border-white">
                    <i class="fas fa-file-alt mr-2"></i>Cara Daftar
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Informasi PPDB -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6 bg-indigo-50 rounded-xl">
                <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Jadwal Pendaftaran</h3>
                <p class="text-gray-600">1 Juni - 31 Juli {{ date('Y') }}</p>
            </div>

            <div class="text-center p-6 bg-green-50 rounded-xl">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-check text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Gratis Biaya Pendaftaran</h3>
                <p class="text-gray-600">Tanpa dipungut biaya apapun</p>
            </div>

            <div class="text-center p-6 bg-yellow-50 rounded-xl">
                <div class="w-16 h-16 bg-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-laptop text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">100% Online</h3>
                <p class="text-gray-600">Daftar kapan saja, di mana saja</p>
            </div>
        </div>
    </div>
</section>

<!-- Showcase Jurusan -->
<section id="jurusan" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Program Keahlian</h2>
            <p class="text-xl text-gray-600">Pilih jurusan yang sesuai dengan minat dan bakatmu</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($majors as $major)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                @if($major->icon)
                <div class="h-48 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                    <img src="{{ Storage::url($major->icon) }}" alt="{{ $major->name }}" class="h-32 w-32 object-contain">
                </div>
                @else
                <div class="h-48 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-white text-6xl"></i>
                </div>
                @endif

                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">{{ $major->name }}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit(strip_tags($major->description), 120) }}</p>

                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-users mr-1"></i>Kuota: {{ $major->quota }} siswa
                        </span>
                    </div>

                    <a href="{{ route('major.detail', $major->slug) }}" class="block text-center bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
                        Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12 text-gray-500">
                <i class="fas fa-info-circle text-4xl mb-4"></i>
                <p>Belum ada jurusan tersedia</p>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('majors') }}" class="inline-block bg-gray-800 text-white px-8 py-3 rounded-lg hover:bg-gray-900 transition">
                Lihat Semua Jurusan <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Alur Pendaftaran -->
<section id="alur-pendaftaran" class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Alur Pendaftaran</h2>
            <p class="text-xl text-gray-600">Ikuti langkah mudah berikut untuk mendaftar</p>
        </div>

        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white text-3xl font-bold">
                        1
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Registrasi</h3>
                    <p class="text-gray-600 text-sm">Isi formulir pendaftaran online dan pilih jurusan</p>
                </div>

                <!-- Step 2 -->

                <!-- Step 3 -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white text-3xl font-bold">
                        2
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Verifikasi</h3>
                    <p class="text-gray-600 text-sm">Tim kami akan memverifikasi data dan dokumen Anda</p>
                </div>

                <!-- Step 4 -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white text-3xl font-bold">
                        3
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Pengumuman</h3>
                    <p class="text-gray-600 text-sm">Cek hasil seleksi dan lakukan daftar ulang</p>
                </div>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('registration.create') }}" class="inline-block bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-12 py-4 rounded-lg font-bold text-lg hover:shadow-2xl transition transform hover:scale-105">
                <i class="fas fa-rocket mr-2"></i>Daftar Sekarang
            </a>
        </div>
    </div>
</section>

<!-- Persyaratan -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Persyaratan Pendaftaran Ulang</h2>
                <p class="text-xl text-gray-600">Siapkan dokumen-dokumen berikut</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-8">
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 text-xl mr-3 mt-1"></i>
                        <span class="text-gray-700">Ijazah/STTB SMP/MTs atau Surat Keterangan Lulus (SKL)</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 text-xl mr-3 mt-1"></i>
                        <span class="text-gray-700">Fotocopy Kartu Keluarga (KK)</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 text-xl mr-3 mt-1"></i>
                        <span class="text-gray-700">Fotocopy Akta Kelahiran</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 text-xl mr-3 mt-1"></i>
                        <span class="text-gray-700">Pas Foto berwarna 3x4 (2 lembar)</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 text-xl mr-3 mt-1"></i>
                        <span class="text-gray-700">Fotocopy Rapor SMP/MTs Semester 1-5</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 text-xl mr-3 mt-1"></i>
                        <span class="text-gray-700">NISN (Nomor Induk Siswa Nasional)</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Pengumuman Terbaru -->
@if($announcements->count() > 0)
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Pengumuman Terbaru</h2>
            <p class="text-xl text-gray-600">Informasi penting seputar PPDB</p>
        </div>

        <div class="max-w-4xl mx-auto space-y-6">
            @foreach($announcements as $announcement)
            <div class="bg-gray-50 rounded-xl p-6 hover:shadow-lg transition">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $announcement->title }}</h3>
                        <p class="text-gray-600 mb-3">{{ Str::limit(strip_tags($announcement->content), 150) }}</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-calendar mr-2"></i>
                            {{ $announcement->published_at->format('d M Y') }}
                        </div>
                    </div>
                    <a href="{{ route('announcement.detail', $announcement->id) }}" class="ml-4 text-indigo-600 hover:text-indigo-700">
                        <i class="fas fa-arrow-right text-2xl"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('announcements') }}" class="inline-block text-indigo-600 hover:text-indigo-700 font-semibold">
                Lihat Semua Pengumuman <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Cek Status Section -->
<section class="py-16 bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-8">
                <div class="inline-block bg-white/20 backdrop-blur-sm rounded-full px-6 py-2 mb-4">
                    <i class="fas fa-search mr-2"></i>
                    <span class="font-semibold">Sudah Mendaftar?</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Cek Status Pendaftaran Anda</h2>
                <p class="text-lg text-purple-100">Masukkan nomor registrasi untuk melihat status dan update pendaftaran</p>
            </div>

            <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-10">
                <form action="{{ route('registration.showStatus') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-gray-700 font-semibold mb-3 text-left">
                            <i class="fas fa-id-card mr-2 text-indigo-600"></i>Nomor Registrasi
                        </label>
                        <input type="text" name="registration_number" required
                            placeholder="Contoh: REG202500001"
                            class="w-full px-6 py-4 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-purple-500 focus:border-purple-500 text-lg text-center font-semibold tracking-wider uppercase"
                            maxlength="20">
                        <p class="text-sm text-gray-500 mt-2 text-center">
                            <i class="fas fa-info-circle mr-1"></i>
                            Nomor registrasi dikirim ke email setelah pendaftaran
                        </p>
                    </div>

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-4 rounded-xl font-bold text-lg hover:from-purple-700 hover:to-indigo-700 transition transform hover:scale-105 shadow-lg">
                        <i class="fas fa-search mr-2"></i>Cek Status Sekarang
                    </button>
                </form>

                <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                    <p class="text-gray-600 text-sm mb-3">Belum mendaftar?</p>
                    <a href="{{ route('registration.create') }}" class="inline-block text-indigo-600 hover:text-indigo-800 font-semibold">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 hero-gradient text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold mb-4">Siap Bergabung Bersama Kami?</h2>
        <p class="text-xl mb-8 text-indigo-100">Jadilah bagian dari keluarga besar SMK dan raih prestasi gemilang!</p>
        <a href="{{ route('registration.create') }}" class="inline-block bg-white text-indigo-600 px-12 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition transform hover:scale-105">
            <i class="fas fa-pencil-alt mr-2"></i>Daftar Sekarang
        </a>
    </div>
</section>

@endsection
