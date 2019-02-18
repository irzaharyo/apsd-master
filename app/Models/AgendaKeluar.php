<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaKeluar extends Model
{
    protected $table = 'agenda_keluars';

    protected $guarded = ['id'];

    public function getSuratKeluar()
    {
        return $this->belongsTo(SuratKeluar::class, 'suratkeluar_id');
    }
}
