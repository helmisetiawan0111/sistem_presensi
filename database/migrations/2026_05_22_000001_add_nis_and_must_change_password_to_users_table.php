<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the unique index on email so we can change the column to nullable
            $table->dropUnique(['email']);
            // Make email nullable
            $table->string('email')->nullable()->change();
            // Add back the unique index on email
            $table->unique('email');
            // Add nis column (nullable and unique)
            $table->string('nis')->nullable()->unique()->after('email');
            // Add must_change_password flag
            $table->boolean('must_change_password')->default(false)->after('nis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nis', 'must_change_password']);
            // Drop unique index on email
            $table->dropUnique(['email']);
            // Make email not nullable (assuming we want to revert to original state)
            $table->string('email')->nullable(false)->change();
            // Add back the unique index on email
            $table->unique('email');
        });
    }
};