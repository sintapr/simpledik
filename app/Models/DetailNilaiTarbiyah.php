<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailNilaiTarbiyah extends Model
{
    protected $table = 'detail_nilai_tarbiyah';
    protected $primaryKey = 'id_detail_nilai_tarbiyah';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_detail_nilai_tarbiyah', 'id_rapor', 'id_materi', 'nilai'];
    public $timestamps = false;

    public function rapor()
    {
        return $this->belongsTo(MonitoringSemester::class, 'id_rapor');
    }

    public function materi()
    {
        return $this->belongsTo(MateriTarbiyah::class, 'id_materi');
    }
}
