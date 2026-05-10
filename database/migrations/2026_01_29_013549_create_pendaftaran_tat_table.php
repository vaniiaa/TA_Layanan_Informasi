<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftaran_tat', function (Blueprint $table) {
            $table->id();

            // Data Pemohon
            $table->string('nama_lengkap');
            $table->text('alamat');
            $table->string('instansi');
            $table->string('nama_penyidik');
            $table->string('wa_penyidik');

            $table->date('tanggal_surat_pengajuan');
            $table->string('file_surat_permohonan')->nullable();

            $table->date('tanggal_lp');
            $table->string('file_lp')->nullable();

            $table->date('tanggal_penangkapan');
            $table->string('file_penangkapan')->nullable();

            // Identitas Tersangka
            $table->string('nama_tersangka');
            $table->string('file_identitas')->nullable();

            // Data Narkotika
            $table->json('barang_bukti')->nullable();
            $table->string('berat_barang_bukti')->nullable();
            $table->json('hasil_urine')->nullable();

            $table->string('konfirmasi');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_tat');
    }
};
