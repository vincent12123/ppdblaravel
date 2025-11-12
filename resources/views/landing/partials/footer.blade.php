<footer class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- About -->
            <div>
                <h3 class="text-lg font-bold mb-4">PPDB SMK</h3>
                <p class="text-gray-400 text-sm">
                    Sistem Penerimaan Peserta Didik Baru online yang memudahkan calon siswa untuk mendaftar ke SMK kami.
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
                    <li><i class="fas fa-phone mr-2"></i> (0265) 123-4567</li>
                    <li><i class="fas fa-envelope mr-2"></i> ppdb@smk.sch.id</li>
                    <li><i class="fas fa-map-marker-alt mr-2"></i> Jl. Pendidikan No. 123</li>
                </ul>
            </div>

            <!-- Social Media -->
            <div>
                <h3 class="text-lg font-bold mb-4">Ikuti Kami</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-facebook text-2xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-instagram text-2xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-youtube text-2xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-whatsapp text-2xl"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
            <p>&copy; {{ date('Y') }} PPDB SMK. All rights reserved. Powered by Laravel & Filament.</p>
        </div>
    </div>
</footer>
