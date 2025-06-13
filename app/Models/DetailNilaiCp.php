<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailNilaiCp extends Model
{
    protected $table = 'detail_nilai_cp';
    protected $primaryKey = 'id_detail_nilai_cp';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['id_detail_nilai_cp', 'id_rapor', 'id_penilaian_cp', 'nilai', 'foto'];

    public function rapor()
    {
        return $this->belongsTo(MonitoringSemester::class, 'id_rapor');
    }

    public function penilaian()
    {
        return $this->belongsTo(PenilaianCp::class, 'id_penilaian_cp');
    }
}
