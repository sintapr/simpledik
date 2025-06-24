<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailNilaiP5 extends Model
{
    protected $table = 'detail_nilai_p5';
    protected $primaryKey = 'id_detail_nilai_p5';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['id_detail_nilai_p5', 'id_rapor', 'id_perkembangan', 'nilai','foto'];

    public function rapor()
    {
        return $this->belongsTo(MonitoringSemester::class, 'id_rapor');
    }

    public function perkembangan()
    {
        return $this->belongsTo(Perkembangan::class, 'id_perkembangan');
    }
}
