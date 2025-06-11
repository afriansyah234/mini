<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tugas', function (Blueprint $table) {
            $table->foreignId('deadline_id')->constrained()->cascadeOnDelete();
            $table->foreignId('karyawan_id')->constrainded();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->date('deadline')->nullable()->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tugas', function (Blueprint $table) {
            //
        });

        Schema::table('projects', function (Blueprint $table) {
            //
        });
    }
};
