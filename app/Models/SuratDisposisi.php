<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratDisposisi extends Model
{
    protected $table = 'surat_disposisis';

    protected $guarded = ['id'];

    public function getSuratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'suratmasuk_id');
    }
}
