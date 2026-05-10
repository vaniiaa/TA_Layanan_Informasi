<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sosialisasi_narkoba', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('instansi');
            $table->string('alamat');
            $table->string('no_hp', 50);
            $table->string('nama_kegiatan');
            $table->date('tanggal_kegiatan');
            $table->string('waktu_kegiatan');
            $table->string('lokasi');
            $table->string('peserta');
            $table->integer('jumlah_peserta');
            $table->string('surat_permohonan');
            $table->string('konfirmasi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sosialisasi_narkoba');
    }
};
