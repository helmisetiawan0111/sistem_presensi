<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Hapus data jam_pelajaran yang bukan Safinatunnajah atau Muqodimah (kelas NULL atau lainnya)
        \DB::table('jam_pelajaran')->whereNotIn('kelas', ['Safinatunnajah', 'Muqodimah'])->delete();
    }

    public function down(): void
    {
        // Tidak perlu rollback (data sudah hilang)
    }
};
