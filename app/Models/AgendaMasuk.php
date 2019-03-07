<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaMasuk extends Model
{
    protected $table = 'agenda_masuks';

    protected $guarded = ['id'];

    public function getSuratDisposisi()
    {
        return $this->belongsTo(SuratDisposisi::class, 'suratdisposisi_id');
    }
}
