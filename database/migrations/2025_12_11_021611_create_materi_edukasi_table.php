<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materi_edukasi', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', ['artikel', 'infografis', 'modul', 'video']);
            $table->string('judul');
            $table->text('deskripsi')->nullable();

            // ARTIKEL / INFOGRAFIS -> gambar
            $table->string('gambar')->nullable();

            // MODUL -> file PDF
            $table->string('file_modul')->nullable();

            // VIDEO -> link youtube
            $table->string('link_video')->nullable();

            // VIDEO -> upload file .mp4
            $table->string('video_file')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materi_edukasi');
    }
};
