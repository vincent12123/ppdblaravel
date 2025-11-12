@extends('landing.layout')

@section('title', 'Pengumuman - PPDB Online SMK')

@section('content')

<!-- Page Header -->
<section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Pengumuman</h1>
        <p class="text-xl text-indigo-100">Informasi terbaru seputar PPDB</p>
    </div>
</section>

<!-- Announcements List -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">

            @forelse($announcements as $announcement)
            <div class="bg-white rounded-xl shadow-lg p-8 mb-6 hover:shadow-xl transition">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $announcement->title }}</h2>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>{{ $announcement->published_at->format('d F Y, H:i') }} WIB</span>
                        </div>
                    </div>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                        <i class="fas fa-check-circle mr-1"></i>Aktif
                    </span>
                </div>

                <div class="text-gray-700 mb-6 prose max-w-none">
                    {{ Str::limit(strip_tags($announcement->content), 250) }}
                </div>

                <a href="{{ route('announcement.detail', $announcement->id) }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                    Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            @empty
            <div class="bg-white rounded-xl shadow-lg p-12 text-center text-gray-500">
                <i class="fas fa-info-circle text-6xl mb-4"></i>
                <p class="text-xl">Belum ada pengumuman</p>
            </div>
            @endforelse

            <!-- Pagination -->
            @if($announcements->hasPages())
            <div class="mt-8">
                {{ $announcements->links() }}
            </div>
            @endif

        </div>
    </div>
</section>

@endsection
