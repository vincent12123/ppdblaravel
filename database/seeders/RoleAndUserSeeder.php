<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin', 'tu', 'calon_siswa'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Admin (Super Admin)
        $admin = User::firstOrCreate(
            ['email' => 'tukarsa@karyabangsa.sch.id'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('sIntang2025'),
            ]
        );
        $admin->assignRole('admin');

        // TU (Tata Usaha)
        $tu = User::firstOrCreate(
            ['email' => 'tu@example.com'],
            [
                'name' => 'Petugas TU',
                'password' => Hash::make('password'),
            ]
        );
        $tu->assignRole('tu');

        // Calon Siswa (Peserta PPDB)
        $calonSiswa = User::firstOrCreate(
            ['email' => 'siswa@example.com'],
            [
                'name' => 'Calon Siswa',
                'password' => Hash::make('password'),
            ]
        );
        $calonSiswa->assignRole('calon_siswa');
    }
}
