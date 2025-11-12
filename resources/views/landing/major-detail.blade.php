@extends('landing.layout')

@section('title', $major->name . ' - PPDB Online SMK')

@section('content')

<!-- Page Header -->
<section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="flex items-center mb-4">
            <a href="{{ route('majors') }}" class="text-white hover:text-indigo-200 mr-3">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <span class="text-indigo-200">Kembali ke Daftar Jurusan</span>
        </div>
        <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $major->name }}</h1>
        <p class="text-xl text-indigo-100">{{ strip_tags($major->description) }}</p>
    </div>
</section>

<!-- Major Detail -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">

            <!-- Info Card -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-4 bg-indigo-50 rounded-lg">
                        <i class="fas fa-users text-indigo-600 text-3xl mb-3"></i>
                        <h3 class="font-bold text-gray-800 mb-1">Kuota Siswa</h3>
                        <p class="text-2xl font-bold text-indigo-600">{{ $major->quota }}</p>
                    </div>

                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <i class="fas fa-clock text-green-600 text-3xl mb-3"></i>
                        <h3 class="font-bold text-gray-800 mb-1">Lama Studi</h3>
                        <p class="text-2xl font-bold text-green-600">3 Tahun</p>
                    </div>

                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        <i class="fas fa-certificate text-yellow-600 text-3xl mb-3"></i>
                        <h3 class="font-bold text-gray-800 mb-1">Sertifikasi</h3>
                        <p class="text-2xl font-bold text-yellow-600">Kompetensi</p>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-indigo-600 mr-3"></i>
                    Deskripsi Jurusan
                </h2>
                <div class="prose max-w-none text-gray-700">
                    {!! $major->description !!}
                </div>
            </div>

            <!-- Fasilitas -->
            @if($major->facilities)
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-building text-indigo-600 mr-3"></i>
                    Fasilitas Pendukung
                </h2>
                <div class="prose max-w-none text-gray-700">
                    {!! $major->facilities !!}
                </div>
            </div>
            @endif

            <!-- Prospek Karir -->
            @if($major->career_prospects)
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-briefcase text-indigo-600 mr-3"></i>
                    Prospek Karir Lulusan
                </h2>
                <div class="prose max-w-none text-gray-700">
                    {!! $major->career_prospects !!}
                </div>
            </div>
            @endif

            <!-- CTA -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-lg p-8 text-white text-center">
                <h2 class="text-3xl font-bold mb-4">Tertarik dengan Jurusan Ini?</h2>
                <p class="text-xl mb-6 text-indigo-100">Daftar sekarang dan jadilah bagian dari jurusan {{ $major->name }}</p>
                <a href="{{ route('registration.create') }}" class="inline-block bg-white text-indigo-600 px-12 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition transform hover:scale-105">
                    <i class="fas fa-rocket mr-2"></i>Daftar Sekarang
                </a>
            </div>

        </div>
    </div>
</section>

@endsection
