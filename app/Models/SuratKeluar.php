<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    protected $table = 'surat_keluars';

    protected $guarded = ['id'];

    protected $casts = ['files' => 'array'];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getJenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_id');
    }

    public function getSuratDisposisi()
    {
        return $this->belongsTo(SuratDisposisi::class, 'suratdisposisi_id');
    }

    public function getAgendaKeluar()
    {
        return $this->hasOne(AgendaKeluar::class, 'suratkeluar_id');
    }
}
