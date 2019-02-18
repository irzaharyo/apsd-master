<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuks';

    protected $guarded = ['id'];

    protected $casts = ['files' => 'array'];

    public function getJenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_id');
    }

    public function getSuratDisposisi()
    {
        return $this->hasMany(SuratDiposisi::class, 'suratmasuk_id');
    }
}
