<?php

use App\Models\JenisSurat;
use Faker\Factory;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    CONST SURAT = [
        'Surat Biasa',
        'Surat Keterangan',
        'Surat Perintah',
        'Surat Izin',
        'Surat Perjanjian',
        'Surat Perintah Tugas',
        'Surat Perintah Perjalanan Dinas',
        'Surat Kuasa',
        'Surat Undangan',
        'Surat Keterangan Melaksanakan Tugas',
        'Surat Panggilan',
        'Surat Pengantar',
        'Nota Dinas',
        'Nota Pengajuan Konsep Naskah Dinas',
        'Lembar Disposisi',
        'Telaahan Staf',
        'Pengumuman',
        'Laporan',
        'Rekomendasi',
        'Berita Acara',
        'Memo',
        'Daftar Hadir',
        'Sertifikat',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (static::SURAT as $name) {
            JenisSurat::create([
                'jenis' => $name,
            ]);
        }
    }
}
