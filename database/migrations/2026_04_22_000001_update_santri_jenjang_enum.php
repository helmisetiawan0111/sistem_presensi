<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `santri` CHANGE `jenjang` `jenjang` VARCHAR(255) DEFAULT 'Safinatunnajah'");
        DB::table('santri')->update(['jenjang' => 'Safinatunnajah']);
        DB::statement("ALTER TABLE `santri` MODIFY COLUMN `jenjang` ENUM('Safinatunnajah', 'Muqodimah') DEFAULT 'Safinatunnajah'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `santri` CHANGE `jenjang` `jenjang` VARCHAR(255) DEFAULT 'Ibtidaiyah'");
        DB::table('santri')->update(['jenjang' => 'Ibtidaiyah']);
        DB::statement("ALTER TABLE `santri` MODIFY COLUMN `jenjang` ENUM('Takhosus', 'Ibtidaiyah', 'Tsanawiyah', 'Aliyah') DEFAULT 'Ibtidaiyah'");
    }
};