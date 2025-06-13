<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndikatorTarbiyah extends Model
{
    protected $table = 'indikator_tarbiyah';
    protected $primaryKey = 'id_indikator';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_indikator',
        'indikator',
        'id_perkembangan',
        'semester',
        'status', // tambahkan ini
    ];
    
    public function perkembangan()
    {
        return $this->belongsTo(Perkembangan::class, 'id_perkembangan');
    }

    public function materiTarbiyah()
    {
        return $this->belongsTo(MateriTarbiyah::class, 'id_indikator');
    }
}


