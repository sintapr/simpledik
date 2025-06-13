<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailNilaiHafalan extends Model
{
    protected $table = 'detail_nilai_hafalan';
    protected $primaryKey = 'id_detail_nilai_hafalan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['id_detail_nilai_hafalan', 'id_rapor', 'id_surat', 'nilai'];

    public function rapor()
    {
        return $this->belongsTo(MonitoringSemester::class, 'id_rapor');
    }

    public function surat()
    {
        return $this->belongsTo(SuratHafalan::class, 'id_surat');
    }
}
