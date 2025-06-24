<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assesment extends Model
{
    protected $table = 'assesment';
    protected $primaryKey = 'id_assesment';
    public $incrementing = false; // karena id_assesment adalah VARCHAR
    public $timestamps = false;
    protected $fillable = [
        'id_assesment',
        'NIS',
        'id_tp',
        'sudah_muncul',
        'konteks',
        'tempat_waktu',
        'kejadian_teramati',
        'minggu',
        'bulan',
        'tahun',
        'semester',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'NIS', 'NIS');
    }

    public function tujuan_pembelajaran()
    {
        return $this->belongsTo(TujuanPembelajaran::class, 'id_tp', 'id_tp');
    }
}
