<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jam_pelajaran', function ($table) {
            $table->string('ustadz')->nullable()->after('nama');
        });
        
        // Insert default schedule
        $jadwal = [
            ['Senin', 'Jam 1', 'Ustadz Ahmad', '08:00', '09:00', 1],
            ['Senin', 'Jam 2', 'Ustadz Buhari', '09:00', '10:00', 2],
            ['Senin', 'Jam 3', 'Ustadz Hasan', '10:00', '11:00', 3],
            ['Selasa', 'Jam 1', 'Ustadz Ahmad', '08:00', '09:00', 1],
            ['Selasa', 'Jam 2', 'Ustadz Buhari', '09:00', '10:00', 2],
            ['Selasa', 'Jam 3', 'Ustadz Hasan', '10:00', '11:00', 3],
            ['Rabu', 'Jam 1', 'Ustadz Ahmad', '08:00', '09:00', 1],
            ['Rabu', 'Jam 2', 'Ustadz Buhari', '09:00', '10:00', 2],
            ['Rabu', 'Jam 3', 'Ustadz Hasan', '10:00', '11:00', 3],
            ['Kamis', 'Jam 1', 'Ustadz Ahmad', '08:00', '09:00', 1],
            ['Kamis', 'Jam 2', 'Ustadz Buhari', '09:00', '10:00', 2],
            ['Kamis', 'Jam 3', 'Ustadz Hasan', '10:00', '11:00', 3],
            ['Jumat', 'Jam 1', 'Ustadz Ahmad', '08:00', '09:00', 1],
            ['Sabtu', 'Jam 1', 'Ustadz Ahmad', '08:00', '09:00', 1],
            ['Sabtu', 'Jam 2', 'Ustadz Buhari', '09:00', '10:00', 2],
            ['Sabtu', 'Jam 3', 'Ustadz Hasan', '10:00', '11:00', 3],
        ];
        
        foreach ($jadwal as $data) {
            DB::table('jam_pelajaran')->insert([
                'hari' => $data[0],
                'nama' => $data[1],
                'ustadz' => $data[2],
                'jam_mulai' => $data[3],
                'jam_selesai' => $data[4],
                'urutan' => $data[5],
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('jam_pelajaran', function ($table) {
            $table->dropColumn('ustadz');
        });
    }
};