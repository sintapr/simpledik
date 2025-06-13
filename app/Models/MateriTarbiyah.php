<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MateriTarbiyah extends Model
{
    protected $table = 'materi_tarbiyah';
    protected $primaryKey = 'id_materi';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_materi',
        'materi',
        'id_indikator',
        'semester',
        'status', // ini WAJIB ada
    ];
    
    public function indikator()
    {
        return $this->belongsTo(IndikatorTarbiyah::class, 'id_indikator', 'id_indikator');
    }
}

