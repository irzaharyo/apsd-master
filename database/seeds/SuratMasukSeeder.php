<?php

use App\Support\Role;
use App\Models\PerihalSurat;
use App\Models\AgendaMasuk;
use App\Models\SuratDiposisi;
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
                'tembusan' => '<ul><li>' . $faker->name . '</li><li>' . $faker->name . '</li></ul>',
                'files' => ['file1.jpg', 'file2.jpg'],
                'isDisposisi' => true,
            ]);

            $sd = SuratDiposisi::create([
                'suratmasuk_id' => $sm->id,
                'diteruskan_kepada' => $faker->name,
                'harapan' => $faker->sentence(),
                'catatan' => $faker->sentences(2, true)
            ]);

            AgendaMasuk::create([
                'suratdisposisi_id' => $sd->id,
                'ringkasan' => '<p align="justify">' . $faker->sentences(rand(1, 2), true) . '</p>',
                'keterangan' => $faker->sentence()
            ]);
        }
    }
}
