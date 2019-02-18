<?php

use App\Models\JenisSurat;
use Faker\Factory;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
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
            JenisSurat::create([
                'jenis' => $faker->words(rand(1, 3), true)
            ]);
        }
    }
}
