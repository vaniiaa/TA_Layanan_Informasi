<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BesukTahanan extends Model
{
    protected $table = 'besuk_tahanan';

    protected $fillable = [
        'tahanan_id',
        'hari_kunjungan',
        'tanggal_kedatangan',
        'self_assessment',
        'nama_pembesuk',
        'nama_tahanan',
        'alamat_pembesuk',
        'no_hp',
        'jam_masuk',
        'hubungan',
        'foto_identitas',
        'barang'
    ];
     // RELASI: BesukTahanan belongsTo DataTahanan
    public function tahanan()
    {
        return $this->belongsTo(DataTahanan::class, 'tahanan_id');
    }
}
