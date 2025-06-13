<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaKelas extends Model
{
    protected $table = 'anggota_kelas';
    protected $primaryKey = 'id_anggota';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['id_anggota', 'NIS', 'id_wakel'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'NIS', 'NIS');
    }

    public function waliKelas()
    {
        return $this->belongsTo(WaliKelas::class, 'id_wakel', 'id_wakel');
    }
}
