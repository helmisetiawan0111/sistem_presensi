<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@presensi.com'],
            [
                'name' => 'Ustadz Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create petugas user
        User::firstOrCreate(
            ['email' => 'petugas@presensi.com'],
            [
                'name' => 'Petugas Santri',
                'password' => Hash::make('password'),
                'role' => 'petugas',
            ]
        );

        // Create santri users for existing santri
        $santriList = \App\Models\Santri::where('status', true)->get();
        foreach ($santriList as $santri) {
            $email = strtolower(str_replace(' ', '', $santri->nama)) . '@presensi.com';
            User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $santri->nama,
                    'password' => Hash::make('password'),
                    'role' => 'santri',
                    'santri_id' => $santri->id,
                ]
            );
        }
    }
}