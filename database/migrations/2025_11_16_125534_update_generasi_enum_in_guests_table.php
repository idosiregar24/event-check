<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->enum('generasi', ['22','23','24','25','alumni'])
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            // Kembalikan ke enum lama (jika sebelumnya 21–24)
            $table->enum('generasi', ['21','22','23','24'])
                  ->change();
        });
    }
};
