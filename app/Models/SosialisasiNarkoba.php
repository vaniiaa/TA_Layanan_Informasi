<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SosialisasiNarkoba extends Model
{
    use HasFactory;

    protected $table = 'sosialisasi_narkoba';

    protected $fillable = [
        'nama_lengkap',
        'instansi',
        'alamat',
        'no_hp',
        'nama_kegiatan',
        'tanggal_kegiatan',
        'waktu_kegiatan',
        'lokasi',
        'peserta',
        'jumlah_peserta',
        'surat_permohonan',
        'konfirmasi',
    ];
}
