<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTahanan extends Model
{
    use HasFactory;

    protected $table = 'data_tahanan';

    protected $fillable = [
        'nomor_tahanan',
        'nama_tahanan',
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
        'warga_negara',
        'user_id',
    ];

     public function user()
    {
        return $this->belongsTo(User::class);
    }
}