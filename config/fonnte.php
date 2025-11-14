<?php

return [
    // Master enable switch
    'enabled' => env('FONNTE_ENABLED', false),

    // Primary API token
    'token' => env('FONNTE_TOKEN'),

    // Base URL (allow override)
    'base_url' => env('FONNTE_BASE_URL', 'https://api.fonnte.com'),

    // Default message templates (can be overridden via settings table later)
    'templates' => [
        'accepted' => "Halo {name}, selamat! Anda DITERIMA di jurusan {major}. Nomor registrasi: {reg}.",
        'rejected' => "Halo {name}, mohon maaf Anda belum diterima. Tetap semangat! Nomor registrasi: {reg}.",
        'registered' => "Halo {name}, pendaftaran Anda berhasil. Nomor registrasi: {reg}.",
    ],

    // Timeout in seconds for HTTP calls
    'timeout' => (int) env('FONNTE_TIMEOUT', 15),
];
