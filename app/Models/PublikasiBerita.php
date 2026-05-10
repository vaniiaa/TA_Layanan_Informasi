<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublikasiBerita extends Model
{
    protected $table = 'publikasi_berita';

    protected $fillable = [
        'user_id',
        'jenis',
        'judul',
        'deskripsi',
        'gambar',
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}
}
