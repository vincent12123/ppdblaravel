<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $announcements = [
            [
                'title' => 'Pendaftaran PPDB Gelombang 1 Dibuka!',
                'content' => '<p>Pendaftaran peserta didik baru gelombang 1 tahun ajaran 2025/2026 telah dibuka mulai tanggal 1 November 2025 sampai dengan 31 Desember 2025.</p><p><strong>Syarat Pendaftaran:</strong></p><ul><li>Ijazah SMP/MTs atau Surat Keterangan Lulus</li><li>NISN aktif</li><li>Rapor semester 1-5</li><li>Kartu Keluarga</li><li>Akta Kelahiran</li><li>Pas foto 3x4 (3 lembar)</li></ul>',
                'published_at' => now()->subDays(5),
                'is_active' => true,
            ],
            [
                'title' => 'Jadwal Tes Seleksi PPDB 2025',
                'content' => '<p>Tes seleksi untuk calon peserta didik baru akan dilaksanakan pada:</p><ul><li><strong>Tanggal:</strong> 15 Januari 2026</li><li><strong>Waktu:</strong> 08.00 - 12.00 WIB</li><li><strong>Tempat:</strong> Aula SMK</li></ul><p><strong>Materi Tes:</strong></p><ol><li>Tes Akademik (Matematika, Bahasa Indonesia, Bahasa Inggris)</li><li>Tes Psikologi</li><li>Wawancara</li></ol>',
                'published_at' => now()->subDays(3),
                'is_active' => true,
            ],
            [
                'title' => 'Informasi Biaya Pendidikan 2025/2026',
                'content' => '<p>Biaya pendidikan untuk tahun ajaran 2025/2026 adalah sebagai berikut:</p><ul><li><strong>Biaya Pendaftaran:</strong> Rp 200.000,-</li><li><strong>SPP per Bulan:</strong> Rp 350.000,-</li><li><strong>Seragam & Buku:</strong> Rp 1.500.000,- (sekali bayar)</li></ul><p><em>*Tersedia program beasiswa bagi siswa berprestasi dan kurang mampu</em></p>',
                'published_at' => now()->subDay(),
                'is_active' => true,
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}
