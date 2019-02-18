<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    protected $table = 'jenis_surats';

    protected $guarded = ['id'];

    public function getSuratMasuk()
    {
        return $this->hasMany(SuratMasuk::class, 'jenis_id');
    }

    public function getSuratKeluar()
    {
        return $this->hasMany(SuratKeluar::class, 'jenis_id');
    }
}
