<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSekolah extends Model
{
    use HasFactory;

    protected $table = 'data_sekolahs'; 

    protected $fillable = [
    'npsn',
        'nama_sekolah',
        'alamat',
        'status_sekolah',
        'bentuk_pendidikan',
        'user_id',
    ];

   public function user()
    {
        return $this->belongsTo(User::class);
    }
}