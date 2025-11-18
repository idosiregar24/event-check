<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {

            // tambah kolom generasi
            $table->enum('generasi', ['21','22','23','24'])
                  ->after('name');

            // tambah kolom alergi makanan
            $table->string('alergi_makanan')->nullable()
                  ->after('phone');

            // hapus kolom kode undian jika ada
            if (Schema::hasColumn('guests', 'kode_undian')) {
                $table->dropColumn('kode_undian');
            }
        });
    }

    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            // rollback kolom yang ditambah
            $table->dropColumn(['generasi', 'alergi_makanan']);

            // kembalikan kolom kode undian
            $table->string('kode_undian')->nullable();
        });
    }
};
