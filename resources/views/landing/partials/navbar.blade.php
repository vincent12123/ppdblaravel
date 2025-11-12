<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <i class="fas fa-graduation-cap text-3xl text-indigo-600"></i>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">PPDB SMK</h1>
                    <p class="text-xs text-gray-500">Penerimaan Peserta Didik Baru</p>
                </div>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('landing') }}" class="text-gray-700 hover:text-indigo-600 font-medium transition">Beranda</a>
                <a href="{{ route('majors') }}" class="text-gray-700 hover:text-indigo-600 font-medium transition">Jurusan</a>
                <a href="{{ route('announcements') }}" class="text-gray-700 hover:text-indigo-600 font-medium transition">Pengumuman</a>
                <a href="{{ route('registration.checkStatus') }}" class="text-gray-700 hover:text-indigo-600 font-medium transition">
                    <i class="fas fa-search mr-1"></i>Cek Status
                </a>
                <a href="{{ route('registration.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 text-white px-5 py-2 rounded-lg hover:from-green-600 hover:to-green-700 transition font-semibold shadow-lg">
                    <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                </a>
                <a href="{{ route('login') }}" class="text-indigo-600 border-2 border-indigo-600 px-5 py-2 rounded-lg hover:bg-indigo-600 hover:text-white transition font-semibold">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden text-gray-700 focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4 space-y-3">
            <a href="{{ route('landing') }}" class="block text-gray-700 hover:text-indigo-600 font-medium">Beranda</a>
            <a href="{{ route('majors') }}" class="block text-gray-700 hover:text-indigo-600 font-medium">Jurusan</a>
            <a href="{{ route('announcements') }}" class="block text-gray-700 hover:text-indigo-600 font-medium">Pengumuman</a>
            <a href="{{ route('registration.checkStatus') }}" class="block text-gray-700 hover:text-indigo-600 font-medium">
                <i class="fas fa-search mr-2"></i>Cek Status Pendaftaran
            </a>
            <a href="{{ route('registration.create') }}" class="block bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-2 rounded-lg text-center hover:from-green-600 hover:to-green-700 font-semibold shadow-lg">
                <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
            </a>
            <a href="{{ route('login') }}" class="block text-indigo-600 border-2 border-indigo-600 px-6 py-2 rounded-lg text-center hover:bg-indigo-600 hover:text-white font-semibold">
                <i class="fas fa-sign-in-alt mr-2"></i>Login
            </a>
        </div>
    </div>
</nav>

<script>
    document.getElementById('mobile-menu-btn').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>
