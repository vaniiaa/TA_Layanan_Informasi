<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('besuk_tahanan', function (Blueprint $table) {
            $table->id();

            // Data Permohonan
            $table->string('verifikasi');
            $table->string('jenis_besuk');
            $table->string('hari_kunjungan');
            $table->date('tanggal_kedatangan');

            // Data Pembesuk
            $table->string('self_assessment')->nullable(); // VARCHAR, string, disimpan seperti: "sehat,perjalanan,banyak_orang"
            $table->string('nama_pembesuk');
            $table->string('nama_tahanan');
            $table->string('alamat_pembesuk');
            $table->string('no_hp');
            $table->time('jam_masuk');
            $table->string('hubungan');
            $table->string('foto_identitas'); // file
            $table->string('barang')->nullable(); // VARCHAR, disimpan seperti: "makanan,pakaian,ibadah"

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('besuk_tahanan');
    }
};
