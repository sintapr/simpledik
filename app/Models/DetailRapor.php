<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailRapor extends Model
{
    protected $table = 'detail_rapor';
    protected $primaryKey = 'no_detail_rapor';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['no_detail_rapor', 'id_rapor', 'id_perkembangan'];

    public function rapor()
    {
        return $this->belongsTo(MonitoringSemester::class, 'id_rapor');
    }

    public function perkembangan()
    {
        return $this->belongsTo(Perkembangan::class, 'id_perkembangan');
    }
}
