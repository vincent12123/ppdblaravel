@extends('landing.layout')

@section('title', $announcement->title . ' - PPDB Online SMK')

@section('content')

<!-- Page Header -->
<section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="flex items-center mb-4">
            <a href="{{ route('announcements') }}" class="text-white hover:text-indigo-200 mr-3">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <span class="text-indigo-200">Kembali ke Daftar Pengumuman</span>
        </div>
        <div class="max-w-4xl">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $announcement->title }}</h1>
            <div class="flex items-center text-indigo-100">
                <i class="fas fa-calendar mr-2"></i>
                <span>{{ $announcement->published_at->format('d F Y, H:i') }} WIB</span>
            </div>
        </div>
    </div>
</section>

<!-- Announcement Content -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">

            <div class="bg-white rounded-xl shadow-lg p-8 md:p-12">

                <!-- Meta Info -->
                <div class="flex items-center justify-between mb-8 pb-8 border-b border-gray-200">
                    <div class="flex items-center space-x-4">
                        <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-check-circle mr-1"></i>Aktif
                        </span>
                    </div>
                    <div class="text-gray-500 text-sm">
                        <i class="fas fa-eye mr-2"></i>Dipublikasikan {{ $announcement->published_at->diffForHumans() }}
                    </div>
                </div>

                <!-- Content -->
                <div class="prose prose-lg max-w-none">
                    {!! $announcement->content !!}
                </div>

                <!-- Share Section -->
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Bagikan Pengumuman</h3>
                    <div class="flex space-x-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            <i class="fab fa-facebook mr-2"></i>Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($announcement->title) }}" target="_blank" class="bg-sky-500 text-white px-4 py-2 rounded-lg hover:bg-sky-600 transition">
                            <i class="fab fa-twitter mr-2"></i>Twitter
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($announcement->title . ' ' . url()->current()) }}" target="_blank" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            <i class="fab fa-whatsapp mr-2"></i>WhatsApp
                        </a>
                    </div>
                </div>

            </div>

            <!-- Back Button -->
            <div class="mt-8 text-center">
                <a href="{{ route('announcements') }}" class="inline-block bg-gray-800 text-white px-8 py-3 rounded-lg hover:bg-gray-900 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Pengumuman
                </a>
            </div>

        </div>
    </div>
</section>

@endsection
