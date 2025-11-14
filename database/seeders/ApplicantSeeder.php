<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\Document;
use App\Models\Major;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Pastikan sudah ada data jurusan
        $majorIds = Major::query()->pluck('id')->all();
        if (count($majorIds) === 0) {
            $this->command->warn('Tidak ada data jurusan. Jalankan MajorSeeder terlebih dahulu.');
            return;
        }

        $originSchools = [
            'SMPN 1 Kota', 'SMPN 2 Kota', 'SMP Islam Terpadu Harapan', 'MTs Al-Hikmah', 'SMP PGRI 3',
            'SMP Muhammadiyah 1', 'SMPN 5 Kabupaten', 'SMP Kristen Gloria', 'SMP Santa Maria', 'SMP IT Nurul Fikri',
        ];

        $statuses = ['registered', 'verified', 'accepted', 'rejected', 'registered_final'];

        // Buat 20 pendaftar contoh
        for ($i = 0; $i < 20; $i++) {
            // Acak pilihan jurusan
            $shuffledMajors = $majorIds;
            shuffle($shuffledMajors);
            $choice1 = $shuffledMajors[0];
            $choice2 = $shuffledMajors[1] ?? null;
            $choice3 = $shuffledMajors[2] ?? null;

            // Sebagian pendaftar tidak mengisi pilihan 2/3
            if ($faker->boolean(30)) { $choice2 = null; }
            if ($faker->boolean(50)) { $choice3 = null; }

            $status = $faker->randomElement($statuses);

            $applicant = new Applicant();
            $applicant->registration_number = Applicant::generateRegistrationNumber();
            $applicant->name = $faker->name();
            $applicant->nisn = (string) $faker->unique()->numberBetween(1000000000, 9999999999);
            $applicant->birth_date = $faker->dateTimeBetween('-17 years', '-14 years')->format('Y-m-d');
            $applicant->gender = $faker->randomElement(['male', 'female']);
            $applicant->email = $faker->boolean(70) ? $faker->unique()->safeEmail() : null; // 70% isi email, 30% kosong
            $applicant->phone = '08' . $faker->numberBetween(100000000, 999999999);
            $applicant->parent_name = $faker->name();
            $applicant->parent_phone = '08' . $faker->numberBetween(100000000, 999999999);
            $applicant->address = $faker->address();
            $applicant->origin_school = $faker->randomElement($originSchools);
            $applicant->major_choice_1 = $choice1;
            $applicant->major_choice_2 = $choice2;
            $applicant->major_choice_3 = $choice3;
            $applicant->status = $status;
            $applicant->assigned_major = $status === 'accepted' ? $choice1 : null;
            $applicant->registered_at = now()->subDays($faker->numberBetween(0, 30));
            $applicant->save();

            // Buat dokumen-dokumen standar untuk pendaftar ini
            $docTypes = ['foto', 'ijazah', 'kartu_keluarga', 'akta_kelahiran', 'rapor'];
            foreach ($docTypes as $type) {
                Document::create([
                    'applicant_id' => $applicant->id,
                    'type' => $type,
                    'file_path' => 'uploads/documents/' . date('Y') . '/' . $applicant->id . '/' . $type . ($type === 'rapor' || $type === 'ijazah' ? '.pdf' : '.jpg'),
                    'is_verified' => $faker->boolean(50),
                    'verification_notes' => $faker->boolean(20) ? $faker->sentence() : null,
                ]);
            }
        }

        $this->command->info('Seeder Applicant selesai: 20 data contoh dibuat beserta dokumen.');
    }
}
