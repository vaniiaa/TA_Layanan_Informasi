<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_tahanan', function (Blueprint $table) {
            $table->date('tanggal_lahir')->nullable();
            $table->integer('umur')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->integer('tinggi_badan')->nullable();
            $table->integer('berat_badan')->nullable();
            $table->string('warna_kulit')->nullable();
            $table->string('warna_mata')->nullable();
            $table->string('bentuk_muka')->nullable();
            $table->string('suku')->nullable();

            $table->date('dimulai_penahanan')->nullable();
            $table->text('pasal_dilanggar')->nullable();
            $table->string('warga_negara')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('data_tahanan', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_lahir',
                'umur',
                'jenis_kelamin',
                'pendidikan',
                'pekerjaan',
                'tinggi_badan',
                'berat_badan',
                'warna_kulit',
                'warna_mata',
                'bentuk_muka',
                'suku',
                'dimulai_penahanan',
                'pasal_dilanggar',
                'warga_negara'
            ]);
        });
    }
};