<?php
// database/migrations/2026_02_27_000000_create_wisata_edukasi_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('wisata_edukasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('alamat');
            $table->foreignId('data_sekolah_id')->constrained('data_sekolah')->cascadeOnDelete(); // relasi
            $table->string('penanggung_jawab');
            $table->string('no_telp', 20);
            $table->date('tanggal_kegiatan');
            $table->time('waktu_kegiatan');
            $table->integer('jumlah_peserta')->default(1);
            $table->string('surat_permohonan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wisata_edukasi');
    }
};