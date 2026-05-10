<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranTAT extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_tat';

    protected $fillable = [
        'nama_lengkap',
        'nik',
        'alamat',
        'instansi',
        'nama_penyidik',
        'wa_penyidik',
        'tanggal_surat_pengajuan',
        'file_surat_permohonan',
        'tanggal_lp',
        'file_lp',
        'tanggal_penangkapan',
        'file_penangkapan',
        'nama_tersangka',
        'file_identitas',
        'barang_bukti',
        'berat_barang_bukti',
        'hasil_urine',
        'konfirmasi',
    ];

    protected $casts = [
        'barang_bukti' => 'array',
        'hasil_urine' => 'array',
    ];
}
