<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $majors = [
            [
                'name' => 'Perhotelan',
                'description' => '<p>Program keahlian yang mempelajari tentang manajemen hotel, pelayanan tamu, dan industri pariwisata. Siswa akan dibekali dengan keterampilan profesional dalam bidang hospitality management.</p>',
                'quota' => 30,
                'duration_years' => 3,
                'facilities' => '<ul><li>Kitchen Training Modern</li><li>Restaurant & Bar Training</li><li>Front Office Lab</li><li>Housekeeping Lab</li><li>Laundry Service</li></ul>',
                'career_prospects' => '<ul><li>Hotel Staff & Manager</li><li>Restaurant Manager</li><li>Event Organizer</li><li>Travel Agent</li><li>Cruise Ship Staff</li></ul>',
                'is_active' => true,
            ],
            [
                'name' => 'Teknik Sepeda Motor',
                'description' => '<p>Program keahlian yang mempelajari tentang perawatan, perbaikan, dan modifikasi sepeda motor. Siswa akan menguasai teknologi otomotif terkini untuk menjadi teknisi profesional.</p>',
                'quota' => 30,
                'duration_years' => 3,
                'facilities' => '<ul><li>Bengkel Motor Lengkap</li><li>Lab Mesin & Kelistrikan</li><li>Peralatan Diagnosis Modern</li><li>Engine Stand</li><li>Alat Uji Emisi</li></ul>',
                'career_prospects' => '<ul><li>Mekanik Sepeda Motor</li><li>Teknisi AHASS/Dealer</li><li>Wirausaha Bengkel</li><li>Quality Control</li><li>Spare Part Specialist</li></ul>',
                'is_active' => true,
            ],
            [
                'name' => 'Rekayasa Perangkat Lunak',
                'description' => '<p>Program keahlian yang mempelajari tentang pengembangan software, web, dan mobile application. Siswa akan dilatih menjadi programmer profesional yang siap kerja di era digital.</p>',
                'quota' => 30,
                'duration_years' => 3,
                'facilities' => '<ul><li>Lab Komputer AC</li><li>Internet Fiber Optik</li><li>Software Development Tools</li><li>Server & Cloud Computing</li><li>Projector & Smart Board</li></ul>',
                'career_prospects' => '<ul><li>Web Developer</li><li>Mobile App Developer</li><li>Software Engineer</li><li>UI/UX Designer</li><li>IT Support & Administrator</li></ul>',
                'is_active' => true,
            ],
        ];

        foreach ($majors as $major) {
            Major::create($major);
        }
    }
}
