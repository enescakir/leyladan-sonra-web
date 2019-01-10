<?php

use Illuminate\Database\Seeder;

class DiagnosisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Diagnosis::class, 50)->create();
    }
}
