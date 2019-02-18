<?php

use App\Models\Carousel;
use Illuminate\Database\Seeder;

class HomeContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Carousel::create([
            'image' => 'c1.jpg',
            'captions' => 'Kelilingi dirimu dengan orang-orang positif yang akan mendukungmu disaat hujan, bukan hanya ketika mentari bersinar.',
        ]);
        Carousel::create([
            'image' => 'c2.jpg',
            'captions' => 'Orang hebat bukanlah orang-orang yang tidak pernah gagal, tetapi mereka tidak pernah menyerah.',
        ]);
        Carousel::create([
            'image' => 'c3.jpg',
            'captions' => 'Ayunkan langkahmu sekarang dan wujudkanlah mimpimu.',
        ]);
    }
}
