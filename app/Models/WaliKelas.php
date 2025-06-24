<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    protected $table = 'wali_kelas';
    protected $primaryKey = 'id_wakel';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = ['id_wakel', 'NIP', 'id_ta', 'id_kelas'];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'NIP', 'NIP');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_ta', 'id_ta');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }
    public function anggotaKelas()
    {
        return $this->hasMany(AnggotaKelas::class, 'id_wakel');
    }
}
