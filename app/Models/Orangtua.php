<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // ✅ Tambahkan ini

class Orangtua extends Model
{
    protected $table = 'orangtua';
    protected $primaryKey = 'id_ortu';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_ortu',
        'NIS',
        'nama_ayah',
        'nama_ibu',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'alamat',
        'password',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'NIS', 'NIS');
    }
}
