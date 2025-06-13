<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_kelas',
        'nama_kelas',
    ];

    public function waliKelas()
    {
        return $this->hasMany(WaliKelas::class, 'id_kelas');
    }

    // Relasi tidak langsung ke anggota kelas lewat wali_kelas
    public function anggota_kelas()
    {
        return $this->hasManyThrough(
            AnggotaKelas::class, // model tujuan
            WaliKelas::class,    // model perantara
            'id_kelas',          // FK di tabel wali_kelas ke kelas
            'id_wakel',          // FK di tabel anggota_kelas ke wali_kelas
            'id_kelas',          // PK di kelas
            'id_wakel'           // PK di wali_kelas
        );
    }
}
