<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Siswa extends Authenticatable
{
    // Tentukan tabel yang digunakan
    protected $table = 'siswa';
    
    // Tentukan primary key yang digunakan
    protected $primaryKey = 'NIS';
    
    // Set apakah primary key auto increment
    public $incrementing = false;
    
    // Tentukan tipe kolom primary key (string karena varchar)
    protected $keyType = 'string';

    // Tentukan kolom-kolom yang dapat diisi

    // Menonaktifkan timestamps jika tidak ada kolom created_at dan updated_at
    public $timestamps = false;

    protected $fillable = [
        'NIS',
        'NIK',
        'NISN',
        'nama_siswa',
        'tempat_lahir',
        'tgl_lahir',
        'nama_kelas',
        'foto',
    ];

     protected $casts = [
        'tgl_lahir' => 'date',
    ];
    
    public function kondisiSiswa()
{
    return $this->hasMany(KondisiSiswa::class, 'NIS', 'NIS');
}

    public function orangtua()
    {
        return $this->hasOne(Orangtua::class, 'NIS', 'NIS');
    }

    public function anggota_kelas()
    {
        return $this->hasMany(AnggotaKelas::class, 'NIS', 'NIS');
    }
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'NIS', 'NIS');
    }

    public function monitoringSemester()
    {
        return $this->hasMany(MonitoringSemester::class, 'NIS', 'NIS');
    }


}


