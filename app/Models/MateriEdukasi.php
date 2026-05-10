<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MateriEdukasi extends Model
{
    protected $table = 'materi_edukasi';

    protected $fillable = [
        'jenis',
         'user_id', 
        'judul',
        'deskripsi',
        'gambar',
        'file_modul',
        'video_file',
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}
}
