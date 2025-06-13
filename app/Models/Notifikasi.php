<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    protected $fillable = [
        'judul', 'pesan', 'untuk_role', 'NIS', 'dibaca',
    ];

    // Relasi ke siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'NIS', 'NIS');
    }
}
