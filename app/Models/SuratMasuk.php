<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuks';

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
        return $this->hasOne(SuratDisposisi::class, 'suratmasuk_id');
    }
}
