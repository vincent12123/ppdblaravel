<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Penerimaan Peserta Didik Baru (PPDB) Online - SMK">
    <title>@yield('title', 'PPDB Online - SMK')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        .animate-fade-in {
            animation: fadeIn 1s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Marquee Animation */
        .marquee-container {
            width: 100%;
            overflow: hidden;
        }
        .marquee-content {
            display: inline-block;
            white-space: nowrap;
            animation: marquee 30s linear infinite;
        }
        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }
            100% {
                transform: translateX(-100%);
            }
        }
        .marquee-content:hover {
            animation-play-state: paused;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50">

    <!-- Navbar -->
    @include('landing.partials.navbar')

    <!-- Marquee Banner -->
    @php
        $marquees = \App\Models\Marquee::active()->ordered()->get();
    @endphp

    @if($marquees->count() > 0)
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-2 overflow-hidden">
        <div class="marquee-container">
            <div class="marquee-content">
                @foreach($marquees as $marquee)
                    <span class="inline-block px-8">
                        <i class="fas fa-bullhorn mr-2"></i>
                        {{ $marquee->text }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('landing.partials.footer')

    <!-- Chatbot Widget -->
    @include('landing.partials.chatbot')

    @stack('scripts')
</body>
</html>
