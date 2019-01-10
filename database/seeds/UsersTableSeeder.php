<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminUser = App\Models\User::create([
            'first_name'  => 'Enes',
            'last_name'   => 'Çakır',
            'email'       => 'enes@cakir.web.tr',
            'password'    => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'faculty_id'  => 1,
            'gender'      => 'Erkek',
            'birthday'    => Carbon::createFromDate(1995, 3, 18)->format('d.m.Y'),
            'mobile'      => '5555951095',
            'year'        => 4,
            'approved_at' => now()
        ]);
        $adminUser->addMediaFromUrl('http://www.leyladansonra.com/resources/admin/uploads/profile_photos/default_l.jpg',
            [], 'profile');
        $adminUser->assignRole('admin');

        $faker = Factory::create();

        factory(App\Models\User::class, 50)->create()->each(function ($user) use ($faker) {
            $user->addMediaFromUrl($faker->imageUrl(512, 512, 'people'),
                [], 'profile');
            $user->assignRole(optional(\App\Models\Role::inRandomOrder()->first())->name);
        });

    }
}