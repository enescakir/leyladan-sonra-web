<?php

use Illuminate\Database\Seeder;

class FacultiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Faculty::class, 10)->create()->each(function ($faculty){
            $faculty->addMediaFromUrl("http://www.leyladansonra.com/resources/admin/uploads/faculty_logos/istanbultip.png");
        });

    }
}