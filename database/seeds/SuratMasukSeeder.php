<?php

use App\Support\Role;
use App\Models\PerihalSurat;
use App\Models\AgendaKeluar;
use App\Models\AgendaMasuk;
use App\Models\SuratKeluar;
use App\Models\SuratDisposisi;
use App\Models\SuratMasuk;
use App\Models\JenisSurat;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class SuratMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');
        for ($c = 1; $c <= 25; $c++) {
            $sm = SuratMasuk::create([
                'user_id' => User::where('role', Role::PENGOLAH)->inRandomOrder()->first()->id,
                'jenis_id' => rand(JenisSurat::min('id'), JenisSurat::max('id')),
                'tgl_surat' => $faker->date('Y-m-d'),
                'no_surat' => PerihalSurat::inRandomOrder()->first()->kode . '/' .
                    str_pad($c, 3, '0', STR_PAD_LEFT) . '/' .
                    $faker->randomNumber(3) . '.' . $faker->randomNumber(3) . '/' . rand(2018, 2019),
                'sifat_surat' => rand(0, 1) ? 'segera' : 'penting',
                'lampiran' => '2 (dua) lembar',
                'perihal' => $faker->sentence(rand(3, 6), true),
                'nama_instansi' => $faker->company,
                'asal_instansi' => $faker->city,
                'nama_pengirim' => $faker->name,
                'jabatan_pengirim' => $faker->jobTitle,
                'nip_pengirim' => $faker->nik(),
                'tembusan' => '<ol><li>' . $faker->name . '</li><li>' . $faker->name . '</li></ol>',
                'files' => ['file1.jpg', 'file2.jpg'],
                'isDisposisi' => true,
            ]);

            $sd = SuratDisposisi::create([
                'suratmasuk_id' => $sm->id,
                'diteruskan_kepada' => '<ol><li>' . $faker->name . '</li><li>' . $faker->name . '</li></ol>',
                'harapan' => $faker->sentence(),
                'catatan' => $faker->sentences(2, true)
            ]);

            AgendaMasuk::create([
                'suratdisposisi_id' => $sd->id,
                'ringkasan' => '<p align="justify">' . $faker->sentences(rand(1, 2), true) . '</p>',
                'keterangan' => $faker->sentence()
            ]);

            $sk = SuratKeluar::create([
                'user_id' => User::where('role', Role::KADIN)->inRandomOrder()->first()->id,
                'jenis_id' => $sm->jenis_id,
                'suratdisposisi_id' => $sd->id,
                'tgl_surat' => $sm->tgl_surat,
                'nama_penerima' => $sm->nama_pengirim,
                'kota_penerima' => $sm->asal_instansi,
                'no_surat' => substr($sm->no_surat, 0, 3) . '/' .
                    str_pad(SuratKeluar::count() + 1, 3, '0', STR_PAD_LEFT) .
                    '/401.113/' . rand(2018, 2019),
                'sifat_surat' => $sm->sifat_surat,
                'lampiran' => '2 (dua) lembar',
                'perihal' => 'Surat balasan ' . $faker->sentence(rand(3, 6), true),
                'isi' => '<p align="justify">' . $faker->paragraphs(rand(2, 3), true) . '</p>',
                'tembusan' => '<ol><li>' . $faker->name . '</li><li>' . $faker->name . '</li></ol>',
                'status' => 4,
                'files' => ['file1.jpg', 'file2.jpg'],
            ]);

            AgendaKeluar::create([
                'suratkeluar_id' => $sk->id,
                'ringkasan' => '<p align="justify">' . $faker->sentences(rand(1, 2), true) . '</p>',
                'keterangan' => $faker->sentence()
            ]);
        }
    }
}
