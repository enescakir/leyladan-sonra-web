@extends('front.parent')

@section('page-title')
    404
@endsection


@section('page-content')
    <section id="slider" class="slider-parallax full-screen dark error404-wrap" style="background: url(/resources/front/images/landing/static.jpg) center;">
        <div class="slider-parallax-inner">

            <div class="container vertical-middle center clearfix">

                <div class="error404">404</div>

                <div class="heading-block nobottomborder">
                    <h4>Aradığınız sayfa bulunamadı maalesef</h4>
                    <span>Başka bir sayfaya girmeyi deneyebilirsiniz.</span>
                </div>

                {{--<form action="#" method="get" role="form" class="divcenter nobottommargin">--}}
                    {{--<div class="input-group input-group-lg">--}}
                        {{--<input type="text" class="form-control" placeholder="Search for Pages...">--}}
							{{--<span class="input-group-btn">--}}
								{{--<button class="btn btn-danger" type="button">Search</button>--}}
							{{--</span>--}}
                    {{--</div>--}}
                {{--</form>--}}

            </div>

        </div>
    </section>
@endsection