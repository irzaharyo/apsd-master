<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratDiposisi extends Model
{
    protected $table = 'surat_disposisis';

    protected $guarded = ['id'];

    public function getSuratMasuk()
    {
        return $this->hasMany(SuratMasuk::class, 'suratmasuk_id');
    }

    public function getAgendaMasuk()
    {
        return $this->hasMany(AgendaMasuk::class, 'suratdisposisi_id');
    }
}
