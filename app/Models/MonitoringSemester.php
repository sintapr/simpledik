<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringSemester extends Model
{
    protected $table = 'monitoring_semester';
    protected $primaryKey = 'id_rapor';
    public $incrementing = false; // Karena id_rapor bukan auto-increment
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_rapor',
        'NIS',
        'id_kelas',
        'NIP',
        'id_fase',
        'id_ta',
    ];

    // Relasi opsional (jika ingin)
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'NIS', 'NIS');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'NIP', 'NIP');
    }

    public function fase()
    {
        return $this->belongsTo(Fase::class, 'id_fase');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_ta');
    }

     public function detailNilaiHafalan()
    {
        return $this->hasMany(DetailNilaiHafalan::class, 'id_rapor', 'id_rapor');
    }

    // Detail nilai Tarbiyah
    public function detailNilaiTarbiyah()
    {
        return $this->hasMany(DetailNilaiTarbiyah::class, 'id_rapor', 'id_rapor');
    }

    // Detail nilai Capaian Perkembangan (CP)
    public function detailNilaiCp()
    {
        return $this->hasMany(DetailNilaiCp::class, 'id_rapor', 'id_rapor');
    }

    // Detail nilai P5
    public function detailNilaiP5()
    {
        return $this->hasMany(DetailNilaiP5::class, 'id_rapor', 'id_rapor');
    }
}
