<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianCp extends Model
{
    protected $table = 'penilaian_cp';
    protected $primaryKey = 'id_penilaian_cp';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['id_penilaian_cp', 'id_perkembangan', 'aspek_nilai'];

    public function perkembangan()
    {
        return $this->belongsTo(Perkembangan::class, 'id_perkembangan');
    }

    
}
