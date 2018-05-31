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

        // create permissions
        Permission::create(['name' => 'list chats', 'display' => 'Sohbetleri Görüntüleme']);
        Permission::create(['name' => 'list faculty children', 'display' => 'Fakülte Çocuklarını Görüntüleme']);
        Permission::create(['name' => 'list children', 'display' => 'Bütün Çocukları Görüntüleme']);
        Permission::create(['name' => 'list diagnosises', 'display' => 'Tanıları Görüntüleme']);

        // create roles and assign created permissions

        $manager = Role::create(['name' => 'manager', 'display' => 'Fakülte Sorumlusu']);
        $board = Role::create(['name' => 'board', 'display' => 'Fakülte Yönetim Kurulu']);
        $relation = Role::create(['name' => 'relation', 'display' => 'İletişim Sorumlusu']);
        $gift = Role::create(['name' => 'gift', 'display' => 'Hediye Sorumlusu']);
        $website = Role::create(['name' => 'website', 'display' => 'Site Sorumlusu']);
        $normal = Role::create(['name' => 'normal', 'display' => 'Normal Üye']);
        $blood = Role::create(['name' => 'blood', 'display' => 'Kan Bağışı Görevlisi']);
        $admin = Role::create(['name' => 'admin', 'display' => 'Yönetici']);

        // $role->givePermissionTo('edit articles');
        // $role->givePermissionTo(['publish articles', 'unpublish articles']);
        // $role->givePermissionTo(Permission::all());
    }
}
