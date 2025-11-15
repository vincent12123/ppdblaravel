<?php

namespace Database\Seeders;

use App\Models\Marquee;
use Illuminate\Database\Seeder;

class MarqueeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $marquees = [
            [
                'text' => 'Selamat datang di Portal PPDB Online! Daftarkan diri Anda sekarang untuk tahun ajaran baru.',
                'is_active' => true,
                'order' => 0,
            ],
            [
                'text' => 'Pendaftaran dibuka mulai 1 Juni 2025 sampai 30 Juni 2025. Jangan sampai terlewat!',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'text' => 'Informasi lebih lanjut hubungi kami di nomor (021) 1234-5678 atau email: info@sekolah.sch.id',
                'is_active' => true,
                'order' => 2,
            ],
        ];

        foreach ($marquees as $marquee) {
            Marquee::create($marquee);
        }
    }
}
