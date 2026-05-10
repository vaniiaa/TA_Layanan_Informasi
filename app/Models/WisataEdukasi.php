<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WisataEdukasi extends Model
{
    use HasFactory;

    protected $table = 'wisata_edukasi'; 

   protected $fillable = [
    'nama_lengkap',
    'alamat',
    'data_sekolah_id',
    'no_telp',
    'tanggal_kegiatan',
    'waktu_kegiatan',
    'jumlah_peserta',
    'surat_permohonan',
];

    // Relasi ke data_sekolahs
    public function sekolah()
    {
        return $this->belongsTo(DataSekolah::class, 'data_sekolah_id');
    }
}