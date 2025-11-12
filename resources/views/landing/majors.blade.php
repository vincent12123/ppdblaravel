@extends('landing.layout')

@section('title', 'Semua Jurusan - PPDB Online SMK')

@section('content')

<!-- Page Header -->
<section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Program Keahlian</h1>
        <p class="text-xl text-indigo-100">Temukan jurusan yang tepat untuk masa depanmu</p>
    </div>
</section>

<!-- Jurusan List -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
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
                    <p class="text-gray-600 mb-4">{{ Str::limit(strip_tags($major->description), 150) }}</p>

                    <div class="mb-4 space-y-2">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-users mr-2 text-indigo-600"></i>
                            <span>Kuota: <strong>{{ $major->quota }}</strong> siswa</span>
                        </div>
                    </div>

                    <a href="{{ route('major.detail', $major->slug) }}" class="block text-center bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                        Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-20 text-gray-500">
                <i class="fas fa-info-circle text-6xl mb-4"></i>
                <p class="text-xl">Belum ada jurusan tersedia</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
