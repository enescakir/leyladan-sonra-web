@extends('admin.parent')

@section('title', 'Tüm Referanslar')

@section('header')
  <section class="content-header">
    <h1>
      Tüm Referanslar
      <small>Sistemimize kayıtlı tüm referanslara buradan ulaşabilirsiniz</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Anasayfa</a></li>
      <li class="active">Referanslar</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">{{ $testimonials->total() }} Referans</h3>
          <div class="box-tools">
            <form action="{{ url()->current() }}" method="GET">
              @foreach (request()->all() as $key => $val)
                @if ($key != "search")
                  <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endif
              @endforeach
              <div class="input-group input-group-sm">
                <input type="text" class="form-control table-search-bar pull-right" name="search" placeholder="Arama" value="{{ request()->search }}">
                <div class="input-group-btn">
                  <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  <a href="{{ route('admin.testimonial.index', array_merge(request()->all(), ['download' => 'true'])) }}" class="btn btn-primary" target="_blank">
                    <i class="fa fa-download"></i>
                  </a>
                  <a href="{{ route('admin.testimonial.create') }}" class="btn btn-success">
                    <i class="fa fa-plus"></i>
                  </a>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-striped table-hover table-bordered table-condensed">
            <thead>
              <tr>
                <th>ID</th>
                <th>Ad</th>
                <th>E-posta</th>
                <th>Öncelik</th>
                <th>Kaynak</th>
                <th>Yazı</th>
                <th class="three-button">İşlem</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($testimonials as $testimonial)
                <tr id="testimonial-{{ $testimonial->id }}">
                  <td>{{ $testimonial->id }}</td>
                  <td>{{ $testimonial->name }}</td>
                  <td>{{ $testimonial->email }}</td>
                  <td>{{ $testimonial->priority }}</td>
                  <td>{{ $testimonial->via }}</td>
                  <td>{{ $testimonial->text }}</td>
                  <td>
                    <div class="btn-group">
                      <button id="approve-testimonial-{{ $testimonial->id }}"
                        class="approve btn btn-default btn-xs @if($testimonial->isApproved()) hidden @endif"
                        approve-id="{{ $testimonial->id }}" approve-name="{{ $testimonial->name }}" is-approve="1"
                        title="Yayınla">
                        <i class="fa fa-square-o"></i>
                      </button>
                      <button id="unapprove-testimonial-{{ $testimonial->id }}"
                        class="approve btn btn-success btn-xs @unless($testimonial->isApproved()) hidden @endunless"
                        approve-id="{{ $testimonial->id }}" approve-name="{{ $testimonial->name }}" is-approve="0"
                        title="Yayından Çıkar">
                        <i class="fa fa-check-square-o"></i>
                      </button>
                      <a class="edit btn btn-warning btn-xs" href="{{ route("admin.testimonial.edit", $testimonial->id) }}">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a class="delete btn btn-danger btn-xs"
                        delete-id="{{ $testimonial->id }}" delete-name="{{ $testimonial->name }}" href="javascript:;">
                        <i class="fa fa-trash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7">Referans bulunmamaktadır.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          {{ $testimonials->appends([
                  'search' => request()->search,
            ])->links() }}
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    deleteItem("testimonial", "referansını silmek istediğinize emin misiniz?");
    approveItem("testimonial",
      "isimli referansı onaylamak istediğinize emin misiniz?",
      "isimli referansın onayını kaldırmak istediğinize emin misiniz?"
    );
  </script>
@endsection
