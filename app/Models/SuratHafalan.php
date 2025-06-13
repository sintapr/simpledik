<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratHafalan extends Model
{

        protected $table = 'surat_hafalan';
        protected $primaryKey = 'id_surat';
        public $incrementing = false;
        protected $keyType = 'string';
        public $timestamps = false;


        protected $fillable = [
            'id_surat',
            'nama_surat',
            'id_perkembangan',
        ];
    
        public function perkembangan()
        {
            return $this->belongsTo(Perkembangan::class, 'id_perkembangan');
        }
    }
    
