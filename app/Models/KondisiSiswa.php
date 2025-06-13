<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KondisiSiswa extends Model
{
    protected $table = 'kondisi_siswa';
    protected $primaryKey = 'id_kondisi';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_kondisi',
        'NIS',
        'BB',
        'TB',
        'LK',
        'penglihatan',
        'pendengaran',
        'gigi',
        'id_ta'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'NIS', 'NIS');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_ta', 'id_ta');
    }
}
