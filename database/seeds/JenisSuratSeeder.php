<?php

use App\Models\JenisSurat;
use Faker\Factory;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    CONST SURAT = [
        'Berita Acara',
        'Daftar Hadir',
        'Laporan',
        'Memo',
        'Nota Dinas',
        'Nota Pengajuan Konsep Naskah Dinas',
        'Pengumuman',
        'Rekomendasi',
        'Sertifikat',
        'Surat Biasa',
        'Surat Izin',
        'Surat Keterangan',
        'Surat Keterangan Melaksanakan Tugas',
        'Surat Kuasa',
        'Surat Panggilan',
        'Surat Pengantar',
        'Surat Perintah',
        'Surat Perintah Tugas',
        'Surat Perintah Perjalanan Dinas',
        'Surat Perjanjian',
        'Surat Undangan',
        'Telaahan Staf',
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
