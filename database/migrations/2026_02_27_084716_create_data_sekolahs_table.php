<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_sekolahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah'); // hanya satu field
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_sekolahs');
    }
};