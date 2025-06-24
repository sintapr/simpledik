<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perkembangan extends Model
{
    protected $table = 'perkembangan';
    protected $primaryKey = 'id_perkembangan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['id_perkembangan', 'indikator'];

    public function indikatorTarbiyah()
    {
        return $this->hasMany(IndikatorTarbiyah::class, 'id_perkembangan');
    }
}
