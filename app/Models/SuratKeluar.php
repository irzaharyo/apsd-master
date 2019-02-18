<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    protected $table = 'surat_keluars';

    protected $guarded = ['id'];

    protected $casts = ['files' => 'array'];

    public function getJenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_id');
    }

    public function getAgendaKeluar()
    {
        return $this->hasMany(AgendaKeluar::class, 'suratkeluar_id');
    }
}
