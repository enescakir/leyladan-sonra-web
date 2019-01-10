<?php

use Illuminate\Database\Seeder;

class SponsorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Sponsor::class, 20)->create()->each(function ($sponsor){
            $sponsor->addMediaFromUrl("http://www.leyladansonra.com/resources/admin/uploads/sponsor_logos/20.png");
        });
    }
}
