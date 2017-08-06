<section class="sidebar">
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel">
    <div class="pull-left image">
      <img src="{{ admin_asset('img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
      <p>Enes Çakır</p>
      <!-- Status -->
      <a href="#"><i class="fa fa-black-tie"></i> Site Sorumlusu</a>
    </div>
  </div>

  <!-- Sidebar Menu -->
  <ul class="sidebar-menu" data-widget="tree">
    <li class="{{ set_active('*admin/dashboard*') }}">
      <a href="{{ route('admin.dashboard') }}"><i class="fa fa-compass"></i> <span>Kontrol Paneli</span></a>
    </li>
    <li><a href="#"><i class="fa fa-address-book-o"></i> <span>Arkadaşlarım</span></a></li>
    <li class="treeview">
      <a href="#"><i class="fa fa-child"></i> <span>Çocuklar</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="#"><i class="fa fa-plus"></i> <span>Yeni Çocuk Ekle</span></a></li>
        <li><a href="#"><i class="fa fa-heart"></i> <span>Kendi Çocuklarım</span></a></li>
        <li><a href="#"><i class="fa fa-bars"></i> <span>Fakülte Çocukları</span></a></li>
        <li><a href="#"><i class="fa fa-list"></i> <span>Bütün Çocukları</span></a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#"><i class="fa fa-university"></i> <span>Fakülteler</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="#"><i class="fa fa-plus"></i> <span>Yeni Fakülte Ekle</span></a></li>
        <li><a href="#"><i class="fa fa-fort-awesome"></i> <span>Bütün Fakülteler</span></a></li>
        <li><a href="#"><i class="fa fa-file-text-o"></i> <span>Onam Formu Oluştur</span></a></li>
      </ul>
    </li>
    <li class="treeview {{ set_active('*blood*', 'menu-open active') }}">
      <a href="#"><i class="fa fa-tint"></i> <span>Kan Bağışı</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu">
        <li class="{{ set_active('*admin/blood/create*') }}">
          <a href="{{ route('admin.blood.create') }}"><i class="fa fa-plus"></i> <span>Yeni Bağışçı Ekle</span></a>
        </li>
        <li class="{{ set_active('*admin/blood') }}">
          <a href="{{ route('admin.blood.index') }}"><i class="fa fa-users"></i> <span>Tüm Bağışçılar</span></a>
        </li>
        <li class="{{ set_active('*admin/blood/sms*') }}">
          <a href="{{ route('admin.blood.sms.send') }}"><i class="fa fa-paper-plane"></i> <span>SMS Gönder</span></a>
        </li>
        <li class="{{ set_active('*admin/blood/people*') }}">
          <a href="{{ route('admin.blood.people.edit') }}"><i class="fa fa-user-circle-o"></i> <span>Görevliler</span></a>
        </li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#"><i class="fa fa-pencil"></i> <span>Yazılar</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="#"><i class="fa fa-folder-o"></i> <span>Fakülte Yazılar</span></a></li>
        <li><a href="#"><i class="fa fa-thumbs-o-up"></i> <span>Onay Bekleyenler</span></a></li>
        <li><a href="#"><i class="fa fa-folder-open-o"></i> <span>Tüm Yazılar</span></a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#"><i class="fa fa-trophy"></i> <span>Gönüllüler</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="#"><i class="fa fa-plus"></i> <span>Yeni Gönüllü Oluştur</span></a></li>
        <li><a href="#"><i class="fa fa-commenting-o"></i> <span>Açık Sohbetler</span></a></li>
        <li><a href="#"><i class="fa fa-comment-o"></i> <span>Fakülte Sohbetleri</span></a></li>
        <li><a href="#"><i class="fa fa-comments"></i> <span>Tüm Sohbetler</span></a></li>
        <li><a href="#"><i class="fa fa-bell-o"></i> <span>Bildirim Gönder</span></a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#"><i class="fa fa-users"></i> <span>Üyeler</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="#"><i class="fa fa-thumbs-o-up"></i> <span>Onay Bekleyenler</span></a></li>
        <li><a href="#"><i class="fa fa-user"></i> <span>Fakülte Üyeleri</span></a></li>
        <li><a href="#"><i class="fa fa-users"></i> <span>Tüm Üyeler</span></a></li>
        <li><a href="#"><i class="fa fa-paper-plane"></i> <span>E-posta Gönder</span></a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#"><i class="fa fa-cog"></i> <span>Ayarlar</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu">
        <li class="{{ set_active('*admin/diagnosis*') }}">
          <a href="{{ route('admin.diagnosis.index') }}"><i class="fa fa-flask"></i> <span>Tanılar</span></a>
        </li>
        <li><a href="#"><i class="fa fa-hospital-o"></i> <span>Departmanlar</span></a></li>
      </ul>
    </li>

    <li class="header">Site</li>
    <li class="treeview">
      <a href="#"><i class="fa fa-newspaper-o"></i> <span>Basında Biz</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="#"><i class="fa fa-plus"></i> <span>Yeni Haber Ekle</span></a></li>
        <li><a href="#"><i class="fa fa-list-alt"></i> <span>Tüm Haberler</span></a></li>
        <li><a href="#"><i class="fa fa-plus"></i> <span>Yeni Kanal Ekle</span></a></li>
        <li><a href="#"><i class="fa fa-television"></i> <span>Kanallar</span></a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#"><i class="fa fa-book"></i> <span>Blog</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="#"><i class="fa fa-plus"></i> <span>Yeni Yazı Ekle</span></a></li>
        <li><a href="#"><i class="fa fa-folder-open-o"></i> <span>Tüm Yazılar</span></a></li>
        <li><a href="#"><i class="fa fa-tags"></i> <span>Yazı Kategorileri</span></a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#"><i class="fa fa-comment-o"></i> <span>Referanslar</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="#"><i class="fa fa-plus"></i> <span>Yeni Referans Ekle</span></a></li>
        <li><a href="#"><i class="fa fa-comments-o"></i> <span>Tüm Referanslar</span></a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#"><i class="fa fa-briefcase"></i> <span>Destekçiler</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="#"><i class="fa fa-plus"></i> <span>Yeni Destekçi Ekle</span></a></li>
        <li><a href="#"><i class="fa fa-suitcase"></i> <span>Tüm Destekçiler</span></a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#"><i class="fa fa-wrench"></i> <span>Hata Girdileri</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="#"><i class="fa fa-tachometer"></i> <span>Genel Görünüm</span></a></li>
        <li><a href="#"><i class="fa fa-list"></i> <span>Ayrıntılı Liste</span></a></li>
      </ul>
    </li>
    <li class="header">Diğer</li>
    <li class="treeview">
      <a href="#"><i class="fa fa-bar-chart"></i> <span>İstatistikler</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="#"><i class="fa fa-child"></i> <span>Çocuklar</span></a></li>
        <li><a href="#"><i class="fa fa-university"></i> <span>Fakülteler</span></a></li>
        <li><a href="#"><i class="fa fa-trophy"></i> <span>Gönüllüler</span></a></li>
        <li><a href="#"><i class="fa fa-tint"></i> <span>Kan Bağışçıları</span></a></li>
        <li><a href="#"><i class="fa fa-users"></i> <span>Üyeler</span></a></li>
        <li><a href="#"><i class="fa fa-globe"></i> <span>Site Ziyareti</span></a></li>
      </ul>
    </li>
    <li><a href="#"><i class="fa fa-bullhorn"></i> <span>Tanıtım Materyalleri</span></a></li>
    <li><a href="#"><i class="fa fa-envelope-open-o"></i> <span>E-posta Örnekleri</span></a></li>
    <li><a href="#"><i class="fa fa-graduation-cap"></i> <span>Kullanma Kılavuzu</span></a></li>
  </ul>
  <!-- /.sidebar-menu -->
</section>
