<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Guru extends Authenticatable
{

    // Nama tabel (jika tidak mengikuti konvensi Laravel)
    protected $table = 'guru';

    // Primary key
    protected $primaryKey = 'NIP';

    // Menandakan kalau primary key bukan auto-increment
    public $incrementing = false;

    // Tipe data primary key
    protected $keyType = 'string';

    // Menonaktifkan timestamps (created_at dan updated_at)
    public $timestamps = false;

    // Mass assignable attributes
    protected $fillable = [
        'NIP',
        'nama_guru',
        'jabatan',
        'tgl_lahir',
        'foto',
        'password',
        'status'
    ];

    // Jika ingin casting tgl_lahir ke Carbon
    protected $casts = [
        'tgl_lahir' => 'date',
    ];

    // App\Models\Guru.php

public function waliKelas()
{
    return $this->hasOne(WaliKelas::class, 'NIP', 'NIP');
}



}
