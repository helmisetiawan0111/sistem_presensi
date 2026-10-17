<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Santri
        $santriData = [
            ['nis' => '001', 'nama' => 'Ahmad Fauzi', 'jenjang' => 'Ibtidaiyah', 'kelas' => '1A', 'alamat' => 'Desa Keranji'],
            ['nis' => '002', 'nama' => 'Bilal Rahman', 'jenjang' => 'Ibtidaiyah', 'kelas' => '1A', 'alamat' => 'Desa Keranji'],
            ['nis' => '003', 'nama' => 'Choirul Anwar', 'jenjang' => 'Ibtidaiyah', 'kelas' => '2A', 'alamat' => 'Desa Margasari'],
            ['nis' => '004', 'nama' => 'Dedi Kurniawan', 'jenjang' => 'Ibtidaiyah', 'kelas' => '2A', 'alamat' => 'Desa Margasari'],
            ['nis' => '005', 'nama' => 'Eko Prasetyo', 'jenjang' => 'Tsanawiyah', 'kelas' => '7A', 'alamat' => 'Desa Sukorejo'],
            ['nis' => '006', 'nama' => 'Fajar Nugroho', 'jenjang' => 'Tsanawiyah', 'kelas' => '7A', 'alamat' => 'Desa Sukorejo'],
            ['nis' => '007', 'nama' => 'Galih Ramadan', 'jenjang' => 'Tsanawiyah', 'kelas' => '8A', 'alamat' => 'Desa Sidomulyo'],
            ['nis' => '008', 'nama' => 'Hendra Wijaya', 'jenjang' => 'Tsanawiyah', 'kelas' => '8A', 'alamat' => 'Desa Sidomulyo'],
            ['nis' => '009', 'nama' => 'Ibrahim Hasan', 'jenjang' => 'Aliyah', 'kelas' => '10A', 'alamat' => 'Desa Tunas Jaya'],
            ['nis' => '010', 'nama' => 'Joko Santoso', 'jenjang' => 'Aliyah', 'kelas' => '10A', 'alamat' => 'Desa Tunas Jaya'],
        ];

        foreach ($santriData as $santri) {
            \App\Models\Santri::firstOrCreate(['nis' => $santri['nis']], $santri);
        }

        // Jam Pelajaran (dengan kelas: Safinatunnajah & Muqodimah)
        $this->call(\Database\Seeders\JamPelajaranSeeder::class);

        // Users
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@presensi.com'],
            [
                'name' => 'Ustadz Admin',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        \App\Models\User::firstOrCreate(
            ['email' => 'petugas@presensi.com'],
            [
                'name' => 'Petugas Santri',
                'password' => bcrypt('password'),
                'role' => 'petugas',
            ]
        );

        // Set usernames after users are created
        $this->call(\Database\Seeders\SetUsernamesSeeder::class);
    }
}