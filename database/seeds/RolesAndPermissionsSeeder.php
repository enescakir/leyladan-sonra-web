<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // create roles and assign created permissions
        $manager = Role::updateOrCreate(['name' => 'manager', 'display' => 'Fakülte Sorumlusu', 'public' => true]);
        $board = Role::updateOrCreate(['name' => 'board', 'display' => 'Fakülte Yönetim Kurulu', 'public' => true]);
        $relation = Role::updateOrCreate(['name' => 'relation', 'display' => 'İletişim Sorumlusu', 'public' => true]);
        $gift = Role::updateOrCreate(['name' => 'gift', 'display' => 'Hediye Sorumlusu', 'public' => true]);
        $website = Role::updateOrCreate(['name' => 'website', 'display' => 'Site Sorumlusu', 'public' => true]);
        $content = Role::updateOrCreate(['name' => 'content', 'display' => 'İçerik Sorumlusu']);
        $normal = Role::updateOrCreate(['name' => 'normal', 'display' => 'Normal Üye', 'public' => true]);
        $blood = Role::updateOrCreate(['name' => 'blood', 'display' => 'Kan Bağışı Görevlisi']);
        $graduated = Role::updateOrCreate(['name' => 'graduated', 'display' => 'Mezun', 'public' => true]);
        $left = Role::updateOrCreate(['name' => 'left', 'display' => 'Ayrılmış Üye', 'public' => true]);
        $admin = Role::updateOrCreate(['name' => 'admin', 'display' => 'Yönetici']);
        $control = Role::updateOrCreate(['name' => 'control', 'display' => 'Denetim Görevlisi']);
    }
}
