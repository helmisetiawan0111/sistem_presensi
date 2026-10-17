<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class SetUsernamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Set username for admin users
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $username = 'admin';
            $counter = 1;
            $original = $username;
            while (User::where('username', $username)->where('id', '!=', $admin->id)->exists()) {
                $username = $original . $counter;
                $counter++;
            }
            $admin->username = $username;
            $admin->save();
        }

        // Set username for petugas users
        $petugasUsers = User::where('role', 'petugas')->get();
        foreach ($petugasUsers as $petugas) {
            $username = 'petugas_presensi';
            $counter = 1;
            $original = $username;
            while (User::where('username', $username)->where('id', '!=', $petugas->id)->exists()) {
                $username = $original . $counter;
                $counter++;
            }
            $petugas->username = $username;
            $petugas->save();
        }
    }
}
