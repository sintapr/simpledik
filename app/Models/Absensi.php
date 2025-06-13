<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';
    protected $primaryKey = 'id_absensi';
    public $incrementing = false; // karena tipe primary key adalah VARCHAR
    public $timestamps = false;

    protected $fillable = [
        'id_absensi',
        'NIS',
        'id_kelas',
        'tanggal',
        'STATUS',
        'id_ta',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'NIS', 'NIS');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_ta', 'id_ta');
    }
}
