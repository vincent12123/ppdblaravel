<nav class="glassmorphism-nav relative">
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <div class="glass-icon-wrapper">
                    <i class="fas fa-graduation-cap text-3xl text-indigo-600"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">SPMB SMK Karya Bangsa Sintang</h1>
                    <p class="text-xs text-gray-500">Penerimaan Peserta Didik Baru</p>
                </div>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('landing') }}" class="nav-link">Beranda</a>
                <a href="{{ route('majors') }}" class="nav-link">Jurusan</a>
                <a href="{{ route('announcements') }}" class="nav-link">Pengumuman</a>
                <a href="{{ route('registration.checkStatus') }}" class="nav-link">
                    <i class="fas fa-search mr-1"></i>Cek Status
                </a>
                <a href="{{ route('registration.create') }}" class="glass-btn-primary">
                    <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                </a>
                <a href="{{ route('login') }}" class="glass-btn-secondary">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden text-gray-700 focus:outline-none glass-mobile-btn">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4 space-y-3 glass-mobile-menu">
            <a href="{{ route('landing') }}" class="block text-gray-700 hover:text-indigo-600 font-medium px-4 py-2 rounded-lg hover:bg-white/30 transition">Beranda</a>
            <a href="{{ route('majors') }}" class="block text-gray-700 hover:text-indigo-600 font-medium px-4 py-2 rounded-lg hover:bg-white/30 transition">Jurusan</a>
            <a href="{{ route('announcements') }}" class="block text-gray-700 hover:text-indigo-600 font-medium px-4 py-2 rounded-lg hover:bg-white/30 transition">Pengumuman</a>
            <a href="{{ route('registration.checkStatus') }}" class="block text-gray-700 hover:text-indigo-600 font-medium px-4 py-2 rounded-lg hover:bg-white/30 transition">
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

<style>
    /* Glassmorphism Navbar Styles */
    .glassmorphism-nav {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        transition: all 0.3s ease;
    }

    /* Scrolled State - More opaque */
    .glassmorphism-nav.scrolled {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(25px) saturate(200%);
        -webkit-backdrop-filter: blur(25px) saturate(200%);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.25);
    }

    /* Glass Icon Wrapper */
    .glass-icon-wrapper {
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 12px;
        padding: 8px 12px;
        box-shadow: 0 4px 16px 0 rgba(99, 102, 241, 0.2);
    }

    /* Navigation Links */
    .nav-link {
        color: #374151;
        font-weight: 500;
        padding: 8px 16px;
        border-radius: 8px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .nav-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(99, 102, 241, 0.1);
        transform: scaleX(0);
        transform-origin: right;
        transition: transform 0.3s ease;
        z-index: -1;
        border-radius: 8px;
    }

    .nav-link:hover::before {
        transform: scaleX(1);
        transform-origin: left;
    }

    .nav-link:hover {
        color: #4f46e5;
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    /* Glass Button Primary (Daftar) */
    .glass-btn-primary {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.9), rgba(5, 150, 105, 0.9));
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        box-shadow: 0 4px 20px 0 rgba(16, 185, 129, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
    }

    .glass-btn-primary:hover {
        background: linear-gradient(135deg, rgba(5, 150, 105, 1), rgba(4, 120, 87, 1));
        transform: translateY(-2px);
        box-shadow: 0 6px 25px 0 rgba(16, 185, 129, 0.5);
    }

    /* Glass Button Secondary (Login) */
    .glass-btn-secondary {
        background: rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        color: #4f46e5;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        border: 2px solid rgba(99, 102, 241, 0.5);
        box-shadow: 0 4px 20px 0 rgba(99, 102, 241, 0.2);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
    }

    .glass-btn-secondary:hover {
        background: rgba(99, 102, 241, 0.9);
        color: white;
        border-color: rgba(99, 102, 241, 0.8);
        transform: translateY(-2px);
        box-shadow: 0 6px 25px 0 rgba(99, 102, 241, 0.3);
    }

    /* Mobile Menu Button */
    .glass-mobile-btn {
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.5);
        transition: all 0.3s ease;
    }

    .glass-mobile-btn:hover {
        background: rgba(255, 255, 255, 0.7);
        transform: scale(1.05);
    }

    /* Mobile Menu */
    .glass-mobile-menu {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-radius: 16px;
        padding: 16px;
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
    }

    /* Shimmer Effect on Hover */
    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }
        100% {
            background-position: 1000px 0;
        }
    }

    .glass-btn-primary::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255, 255, 255, 0.3),
            transparent
        );
        animation: shimmer 3s infinite;
    }
</style>

<script>
    document.getElementById('mobile-menu-btn').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });

    // Add scrolled class for more opacity on scroll
    let lastScrollTop = 0;
    const navbar = document.querySelector('.glassmorphism-nav');

    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }

        lastScrollTop = scrollTop;
    }, false);
</script>
