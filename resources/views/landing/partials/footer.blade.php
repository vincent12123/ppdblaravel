@php
    use App\Models\Setting;
    $schoolName = Setting::get('school_name', 'SMK Negeri 1');
    $schoolDesc = Setting::get('school_description', 'Sistem Penerimaan Peserta Didik Baru online yang memudahkan calon siswa untuk mendaftar ke SMK kami.');
    $schoolPhone = Setting::get('school_phone', '(021) 1234-5678');
    $schoolEmail = Setting::get('school_email', 'ppdb@smk.sch.id');
    $schoolAddress = Setting::get('school_address', 'Jl. Pendidikan No. 123');
    $schoolFacebook = Setting::get('school_facebook', '');
    $schoolInstagram = Setting::get('school_instagram', '');
    $schoolYoutube = Setting::get('school_youtube', '');
    $schoolWhatsapp = Setting::get('school_whatsapp', '');
@endphp

<footer class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- About -->
            <div>
                <h3 class="text-lg font-bold mb-4">PPDB {{ $schoolName }}</h3>
                <p class="text-gray-400 text-sm">
                    {{ $schoolDesc }}
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-bold mb-4">Menu</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('landing') }}" class="text-gray-400 hover:text-white transition">Beranda</a></li>
                    <li><a href="{{ route('majors') }}" class="text-gray-400 hover:text-white transition">Jurusan</a></li>
                    <li><a href="{{ route('announcements') }}" class="text-gray-400 hover:text-white transition">Pengumuman</a></li>
                    <li><a href="#alur-pendaftaran" class="text-gray-400 hover:text-white transition">Cara Daftar</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-lg font-bold mb-4">Kontak</h3>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><i class="fas fa-phone mr-2"></i> {{ $schoolPhone }}</li>
                    <li><i class="fas fa-envelope mr-2"></i> {{ $schoolEmail }}</li>
                    <li><i class="fas fa-map-marker-alt mr-2"></i> {{ $schoolAddress }}</li>
                </ul>
            </div>

            <!-- Social Media -->
            <div>
                <h3 class="text-lg font-bold mb-4">Ikuti Kami</h3>
                <div class="flex space-x-4">
                    @if($schoolFacebook)
                        <a href="{{ $schoolFacebook }}" target="_blank" class="text-gray-400 hover:text-white transition" title="Facebook">
                            <i class="fab fa-facebook text-2xl"></i>
                        </a>
                    @endif
                    @if($schoolInstagram)
                        <a href="{{ $schoolInstagram }}" target="_blank" class="text-gray-400 hover:text-white transition" title="Instagram">
                            <i class="fab fa-instagram text-2xl"></i>
                        </a>
                    @endif
                    @if($schoolYoutube)
                        <a href="{{ $schoolYoutube }}" target="_blank" class="text-gray-400 hover:text-white transition" title="YouTube">
                            <i class="fab fa-youtube text-2xl"></i>
                        </a>
                    @endif
                    @if($schoolWhatsapp)
                        <a href="https://wa.me/{{ $schoolWhatsapp }}" target="_blank" class="text-gray-400 hover:text-white transition" title="WhatsApp">
                            <i class="fab fa-whatsapp text-2xl"></i>
                        </a>
                    @endif
                </div>
                @if(!$schoolFacebook && !$schoolInstagram && !$schoolYoutube && !$schoolWhatsapp)
                    <p class="text-gray-500 text-xs mt-2">Belum ada link media sosial</p>
                @endif
            </div>
        </div>

        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
            <p>&copy; {{ date('Y') }} PPDB {{ $schoolName }}. All rights reserved. Powered by Laravel & Filament.</p>
        </div>
    </div>
</footer>
