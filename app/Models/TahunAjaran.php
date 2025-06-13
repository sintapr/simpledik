<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';
    protected $primaryKey = 'id_ta';
    public $incrementing = false;
    public $timestamps = false;


    protected $fillable = ['id_ta', 'semester', 'tahun_mulai', 'status'];


    public function kondisiSiswa()
    {
        return $this->hasMany(KondisiSiswa::class, 'id_ta', 'id_ta');
    }

    // Accessor untuk semester dengan teks
    public function getSemesterTextAttribute()
    {
        return $this->semester == 1 ? '1 (Satu)' : ($this->semester == 2 ? '2 (Dua)' : '-');
    }

    // Accessor untuk tahun ajaran gabungan
    public function getTahunAjaranAttribute()
    {
        return $this->tahun_mulai . '/' . ($this->tahun_mulai + 1);
    }

    public function waliKelas()
{
    return $this->hasMany(WaliKelas::class, 'id_ta', 'id_ta');
}

}
