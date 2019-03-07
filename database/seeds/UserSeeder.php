<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\User;
use App\Models\Admin;
use App\Support\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');

        for ($c = 0; $c < 10; $c++) {
            User::create([
                'ava' => 'avatar.png',
                'nip' => $faker->nik(),
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('secret'),
                'remember_token' => str_random(60),
                'jabatan' => $faker->jobTitle,
                'alamat' => $faker->address,
                'nmr_hp' => $faker->phoneNumber,
                'jk' => rand(0, 1) ? 'pria' : 'wanita',
                'role' => Role::PEGAWAI
            ]);
        }

        User::find(1)->update([
            'email' => 'kadin@apsd.madiunkota.go.id',
            'name' => 'Kepala Dinas Pertanian',
            'role' => Role::KADIN
        ]);

        User::find(2)->update([
            'email' => 'pengolah@apsd.madiunkota.go.id',
            'name' => 'Pengolah Dinas Pertanian',
            'role' => Role::PENGOLAH
        ]);

        User::find(5)->update([
            'email' => 'tu@apsd.madiunkota.go.id',
            'name' => 'TU Dinas Pertanian',
            'role' => Role::TU
        ]);

        User::find(8)->update([
            'email' => 'pegawai@apsd.madiunkota.go.id',
            'name' => 'Pegawai Dinas Pertanian',
            'role' => Role::PEGAWAI
        ]);

        User::whereIn('id', [3, 4])->update(['role' => Role::PENGOLAH]);

        User::whereIn('id', [6, 7])->update(['role' => Role::TU]);

        for ($c = 0; $c < 5; $c++) {
            Admin::create([
                'ava' => 'avatar.png',
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('secret'),
                'remember_token' => str_random(60),
                'role' => Role::ADMIN
            ]);
        }

        Admin::find(1)->update([
            'email' => 'irza901@gmail.com',
            'name' => 'Irza Haryo Prabowo',
            'role' => 'root'
        ]);
    }
}
