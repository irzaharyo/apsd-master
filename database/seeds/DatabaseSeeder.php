<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            HomeContentSeeder::class,
            UserSeeder::class,
            JenisSuratSeeder::class,
            PerihalSuratSeeder::class,
            SuratKeluarSeeder::class,
            SuratMasukSeeder::class,
        ]);
    }
}
