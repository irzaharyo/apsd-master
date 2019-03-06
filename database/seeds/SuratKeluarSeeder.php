<?php

use App\Support\Role;
use App\Models\User;
use App\Models\PerihalSurat;
use App\Models\AgendaKeluar;
use App\Models\SuratKeluar;
use App\Models\JenisSurat;
use Faker\Factory;
use Illuminate\Database\Seeder;

class SuratKeluarSeeder extends Seeder
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
            $sk = SuratKeluar::create([
                'user_id' => User::where('role', Role::PEGAWAI)->inRandomOrder()->first()->id,
                'jenis_id' => rand(JenisSurat::min('id'), JenisSurat::max('id')),
                'tgl_surat' => $faker->date('Y-m-d'),
                'nama_penerima' => $faker->name,
                'kota_penerima' => $faker->city,
                'no_surat' => PerihalSurat::inRandomOrder()->first()->kode . '/' .
                    str_pad($c, 3, '0', STR_PAD_LEFT) . '/401.113/' . rand(2018, 2019),
                'sifat_surat' => rand(0, 1) ? 'segera' : 'penting',
                'lampiran' => '2 (dua) lembar',
                'perihal' => $faker->sentence(rand(3, 6), true),
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
