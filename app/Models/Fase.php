<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fase extends Model
{
    protected $table = 'fase';
    protected $primaryKey = 'id_fase';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['id_fase', 'nama_fase'];
}
