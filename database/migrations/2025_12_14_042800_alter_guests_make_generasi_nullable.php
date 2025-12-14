<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->string('generasi')->nullable()->change();
            $table->string('program_studi')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->string('generasi')->nullable(false)->change();
            $table->string('program_studi')->nullable(false)->change();
        });
    }
};
