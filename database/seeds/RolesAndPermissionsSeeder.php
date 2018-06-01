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
        Permission::updateOrCreate(['name' => 'create child', 'display' => 'Yeni Çocuk Ekleme']);
        Permission::updateOrCreate(['name' => 'edit child', 'display' => 'Çocuk Düzenleme']);
        Permission::updateOrCreate(['name' => 'delete child', 'display' => 'Çocuk Silme']);
        Permission::updateOrCreate(['name' => 'list own children', 'display' => 'Kendi Çocuklarını Listeleme']);
        Permission::updateOrCreate(['name' => 'list faculty children basic', 'display' => 'Fakülte Çocuklarını Basit Listeleme']);
        Permission::updateOrCreate(['name' => 'list faculty children detail', 'display' => 'Fakülte Çocuklarını Ayrıntılı Listeleme']);
        Permission::updateOrCreate(['name' => 'list children basic', 'display' => 'Bütün Çocukları Basit Listeleme']);
        Permission::updateOrCreate(['name' => 'list children detail', 'display' => 'Bütün Çocukları Ayrıntılı Listeleme']);

        Permission::updateOrCreate(['name' => 'create diagnosis', 'display' => 'Yeni Tanı Ekleme']);
        Permission::updateOrCreate(['name' => 'edit diagnosis', 'display' => 'Tanı Düzenleme']);
        Permission::updateOrCreate(['name' => 'list diagnosises', 'display' => 'Tanıları Listeleme']);

        Permission::updateOrCreate(['name' => 'create faculty', 'display' => 'Yeni Fakülte Ekleme']);
        Permission::updateOrCreate(['name' => 'edit faculty', 'display' => 'Fakülte Düzenleme']);
        Permission::updateOrCreate(['name' => 'list faculties', 'display' => 'Fakülteleri Listeme']);

        Permission::updateOrCreate(['name' => 'create form', 'display' => 'Onam Formu Oluşturma']);

        Permission::updateOrCreate(['name' => 'create blood', 'display' => 'Yeni Kan Bağışçısı Ekleme']);
        Permission::updateOrCreate(['name' => 'edit blood', 'display' => 'Kan Bağışçısı Düzenleme']);
        Permission::updateOrCreate(['name' => 'list bloods', 'display' => 'Kan Bağışçılarını Listeleme']);
        Permission::updateOrCreate(['name' => 'send blood', 'display' => 'Kan Bağışı SMS Gönderme']);
        Permission::updateOrCreate(['name' => 'auth blood', 'display' => 'Kan Bağışı Görevlilerini Seçme']);

        Permission::updateOrCreate(['name' => 'list posts', 'display' => 'Yazıları Listeleme']);
        Permission::updateOrCreate(['name' => 'list faculty posts', 'display' => 'Fakülte Yazılarını Listeleme']);
        Permission::updateOrCreate(['name' => 'edit post', 'display' => 'Yazı Düzenleme']);
        Permission::updateOrCreate(['name' => 'approve post', 'display' => 'Yazı Onaylama']);
        Permission::updateOrCreate(['name' => 'delete post', 'display' => 'Yazı Silme']);

        Permission::updateOrCreate(['name' => 'list users', 'display' => 'Bütün Üyeleri Listeleme']);
        Permission::updateOrCreate(['name' => 'list faculty users', 'display' => 'Fakülte Üyelerini Listeleme']);
        Permission::updateOrCreate(['name' => 'delete user', 'display' => 'Üye Silme']);
        Permission::updateOrCreate(['name' => 'edit user', 'display' => 'Üye Düzenleme']);
        Permission::updateOrCreate(['name' => 'approve user', 'display' => 'Üye Onaylama']);
        Permission::updateOrCreate(['name' => 'auth user', 'display' => 'Üye Yetkilendirme']);
        Permission::updateOrCreate(['name' => 'auth user detail', 'display' => 'Ayrıntılı Üye Yetkilendirme']);

        Permission::updateOrCreate(['name' => 'create volunteer', 'display' => 'Yeni Gönüllü Oluşturma']);
        Permission::updateOrCreate(['name' => 'edit volunteer', 'display' => 'Gönüllü Düzenleme']);
        Permission::updateOrCreate(['name' => 'delete volunteer', 'display' => 'Gönüllü Silme']);
        Permission::updateOrCreate(['name' => 'list volunteers', 'display' => 'Gönüllü Listeleme']);
        Permission::updateOrCreate(['name' => 'list faculty chats', 'display' => 'Fakülte Sohbetlerini Listeleme']);
        Permission::updateOrCreate(['name' => 'list chats', 'display' => 'Sohbetleri Listeleme']);
        Permission::updateOrCreate(['name' => 'edit chats', 'display' => 'Sohbetlere Müdahele Etme']);

        Permission::updateOrCreate(['name' => 'send notification', 'display' => 'Bildirim Gönderme']);
        Permission::updateOrCreate(['name' => 'send email', 'display' => 'Tüm Üyelere E-posta Gönderme']);
        Permission::updateOrCreate(['name' => 'send faculty email', 'display' => 'Fakülte Üyelerine E-posta Gönderme']);

        Permission::updateOrCreate(['name' => 'crud news', 'display' => 'Basında Biz Düzenleme']);
        Permission::updateOrCreate(['name' => 'crud sponsor', 'display' => 'Destekçi Düzenleme']);
        Permission::updateOrCreate(['name' => 'crud testimonial', 'display' => 'Referans Düzenleme']);

        Permission::updateOrCreate(['name' => 'create blog', 'display' => 'Blog Ekleme']);
        Permission::updateOrCreate(['name' => 'edit blog', 'display' => 'Blog Düzenleme']);
        Permission::updateOrCreate(['name' => 'delete blog', 'display' => 'Blog Silme']);
        Permission::updateOrCreate(['name' => 'list blog', 'display' => 'Blogları Listeleme']);

        // create roles and assign created permissions

        $manager = Role::updateOrCreate(['name' => 'manager', 'display' => 'Fakülte Sorumlusu']);
        $manager->syncPermissions([
            'create child', 'edit child', 'delete child', 'list own children', 'list faculty children detail', 'list children basic',
            'list diagnosises',
            'edit faculty', 'list faculties',
            'list faculty posts', 'edit post', 'approve post', 'delete post',
            'list faculty users', 'edit user', 'approve user', 'auth user',
            'create volunteer', 'edit volunteer', 'list volunteers', 'list faculty chats', 'edit chats',
            'send faculty email'
        ]);

        $board = Role::updateOrCreate(['name' => 'board', 'display' => 'Fakülte Yönetim Kurulu']);
        $board->syncPermissions([
            'create child', 'edit child', 'list own children', 'list faculty children detail',
            'list diagnosises',
            'list faculties',
            'list faculty posts',
            'list faculty users',
            'list volunteers', 'list faculty chats'
        ]);

        $relation = Role::updateOrCreate(['name' => 'relation', 'display' => 'İletişim Sorumlusu']);
        $relation->syncPermissions([
            'create child', 'edit child', 'list own children', 'list faculty children basic', 'list children basic',
            'list faculties',
            'create volunteer', 'edit volunteer', 'list volunteers', 'list faculty chats', 'edit chats'
        ]);

        $gift = Role::updateOrCreate(['name' => 'gift', 'display' => 'Hediye Sorumlusu']);
        $manager->syncPermissions([
            'create child', 'edit child', 'list own children', 'list faculty children basic',
            'list volunteers'
        ]);

        $website = Role::updateOrCreate(['name' => 'website', 'display' => 'Site Sorumlusu']);
        $website->syncPermissions([
            'create child', 'edit child', 'list own children', 'list faculty children detail',
            'list faculty posts', 'edit post', 'approve post', 'delete post',
        ]);

        $content = Role::updateOrCreate(['name' => 'content', 'display' => 'İçerik Sorumlusu']);
        $content->syncPermissions([
            'crud news', 'crud sponsor', 'crud testimonial',
            'create blog', 'edit blog', 'delete blog', 'list blog'
        ]);

        $normal = Role::updateOrCreate(['name' => 'normal', 'display' => 'Normal Üye']);
        $normal->syncPermissions([
            'create child', 'edit child', 'list own children'
        ]);

        $blood = Role::updateOrCreate(['name' => 'blood', 'display' => 'Kan Bağışı Görevlisi']);
        $blood->syncPermissions([
            'create child', 'edit child', 'list own children',
            'create blood', 'edit blood', 'list bloods', 'send blood', 'auth blood'
        ]);

        $graduated = Role::updateOrCreate(['name' => 'graduated', 'display' => 'Mezun']);
        $graduated->syncPermissions([
            'list own children'
        ]);

        $left = Role::updateOrCreate(['name' => 'left', 'display' => 'Ayrılmış Üye']);

        $admin = Role::updateOrCreate(['name' => 'admin', 'display' => 'Yönetici']);
        $admin->syncPermissions(Permission::all());
    }
}
