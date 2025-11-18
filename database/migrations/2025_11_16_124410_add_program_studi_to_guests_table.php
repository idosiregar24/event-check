<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {

            $table->enum('program_studi', [
                // Jurusan Teknologi Informasi
                'Teknik Informatika',
                'Sistem Informasi',
                'Teknologi Rekayasa Komputer',
                'Teknologi Rekayasa Sistem Elektronika',
                'Teknologi Rekayasa Jaringan Telekomunikasi',
                'Magister Terapan Teknik Komputer',

                // Jurusan Bisnis dan Komunikasi
                'Akuntansi Perpajakan',
                'Komunikasi Digital',
                'Bisnis Digital',

                // Jurusan Teknik
                'Teknik Mesin',
                'Teknologi Rekayasa Mekatronika',
                'Teknik Elektronika'
            ])->nullable()->after('generasi');
        });
    }

    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropColumn('program_studi');
        });
    }
};
