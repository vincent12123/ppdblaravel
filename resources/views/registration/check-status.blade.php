@extends('landing.layout')

@section('title', 'Cek Status Pendaftaran - PPDB Online SMK')

@section('content')

<!-- Page Header -->
<section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold mb-2">Cek Status Pendaftaran</h1>
        <p class="text-lg text-indigo-100">Masukkan nomor pendaftaran untuk melihat status</p>
    </div>
</section>

<!-- Check Status Form -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">

            <!-- Info Box -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-6 mb-8 rounded-lg">
                <h3 class="font-bold text-gray-800 mb-2 flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                    Informasi
                </h3>
                <p class="text-gray-700">
                    Nomor pendaftaran telah dikirimkan ke email Anda saat mendaftar.
                    Format nomor: <strong>REG2025XXXXX</strong>
                </p>
            </div>

            <!-- Error Message -->
            @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-xl mr-3"></i>
                    <div>
                        @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <form action="{{ route('registration.showStatus') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-3 text-lg">
                            Nomor Pendaftaran <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="registration_number" value="{{ old('registration_number') }}" required
                            class="w-full px-6 py-4 border-2 border-gray-300 rounded-lg text-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="REG2025XXXXX"
                            pattern="REG\d{9}"
                            title="Format: REG2025XXXXX">
                        <p class="text-sm text-gray-500 mt-2">
                            Contoh: REG202500001
                        </p>
                    </div>

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-4 rounded-lg font-bold text-lg hover:shadow-2xl transition transform hover:scale-105">
                        <i class="fas fa-search mr-2"></i>Cek Status
                    </button>
                </form>

                <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                    <p class="text-gray-600 mb-4">Belum mendaftar?</p>
                    <a href="{{ route('registration.create') }}"
                        class="text-indigo-600 hover:text-indigo-800 font-semibold">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                    </a>
                </div>
            </div>

            <!-- Help Section -->
            <div class="mt-8 bg-white rounded-xl shadow-lg p-8">
                <h3 class="font-bold text-gray-800 mb-4 text-xl">Butuh Bantuan?</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <i class="fas fa-question-circle text-indigo-600 text-xl mr-3 mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-1">Lupa Nomor Pendaftaran?</h4>
                            <p class="text-gray-600">
                                Silakan cek email yang Anda gunakan saat mendaftar.
                                Nomor pendaftaran telah dikirimkan otomatis.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-envelope text-indigo-600 text-xl mr-3 mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-1">Email Tidak Diterima?</h4>
                            <p class="text-gray-600">
                                Periksa folder spam/junk. Jika masih tidak ada, hubungi panitia PPDB.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-phone text-indigo-600 text-xl mr-3 mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-1">Kontak Panitia</h4>
                            <p class="text-gray-600">
                                WhatsApp: <a href="https://wa.me/6281234567890" class="text-indigo-600 hover:underline">0812-3456-7890</a><br>
                                Email: <a href="mailto:ppdb@smk.sch.id" class="text-indigo-600 hover:underline">ppdb@smk.sch.id</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('landing') }}" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>
</section>

@endsection
