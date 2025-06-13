<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TujuanPembelajaran extends Model
{
    protected $table = 'tujuan_pembelajaran';
    protected $primaryKey = 'id_tp';
    public $incrementing = false;
    protected $fillable = ['id_tp', 'tujuan_pembelajaran'];
    public $timestamps = false;

}

