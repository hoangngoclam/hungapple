@extends('client.master')
@section('content')
<!-- START SECTION BANNER -->
<div class="banner_section slide_medium shop_banner_slider staggered-animation-wrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 offset-lg-3">
                <div id="carouselExampleControls" class="carousel slide light_arrow" data-ride="carousel">
                    <div class="carousel-inner">
                        @if(isset($sliders) && $sliders)
                        @foreach($sliders as $key => $slider)
                        <div class="carousel-item {{ $key == 0 ? 'active' : ''}} background_bg" data-img-src="{{asset($slider->image)}}">
                            <div class="banner_slide_content banner_content_inner">
                                <div class="col-lg-8 col-10">
                                    <div class="banner_content overflow-hidden">
                                        <h5 class="mb-3 staggered-animation font-weight-light" data-animation="slideInLeft" data-animation-delay="0.5s">{{$slider->content}}</h5>
                                        <h2 class="staggered-animation" data-animation="slideInLeft" data-animation-delay="1s">{{$slider->title}}</h2>
                                        <a class="btn btn-fill-out rounded-0 staggered-animation text-uppercase" href="{{route('client.detail',['id'=> $slider->productId ? $slider->productId : 1])}}" data-animation="slideInLeft" data-animation-delay="1.5s">Mua Ngay</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <ol class="carousel-indicators indicators_style1">
                        @foreach($sliders as $key => $slider)
                            <li data-target="#carouselExampleControls" data-slide-to="{{$key}}" class="{{ $key == 0 ? 'active' : ''}}"></li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION BANNER -->

<!-- END MAIN CONTENT -->
<div class="main_content">
    @foreach ($arrayCategory as $category)
        <div class="section small_pt pb_70">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="heading_s1 text-center">
                            <h2>{{$category["name"]}}</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="tab-style1">
                            <ul class="nav nav-tabs justify-content-center" role="tablist">
                                @foreach ($category["childrenCategory"] as $key => $childCategory)
                                <li class="nav-item">
                                    <a  class="nav-link @if(reset($category["childrenCategory"])["name"] == $childCategory["name"])active @endif" id="category-{{$childCategory["id"]}}" 
                                        data-toggle="tab" href="#Components-{{$childCategory["id"]}}" role="tab" aria-controls="Components-tab{{$childCategory["id"]}}" 
                                        aria-selected="true">
                                        {{$childCategory["name"]}}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="tab-content">
                            @foreach ($category["childrenCategory"] as $key => $childCategory)
                            <div class="tab-pane fade @if(reset($category["childrenCategory"])["name"] == $childCategory["name"])show active @endif" 
                                id="Components-{{$childCategory["id"]}}" role="tabpanel" aria-labelledby="Components-tab{{$childCategory["id"]}}">
                                <div class="row shop_container">
                                    @foreach ($childCategory["products"] as $product)
                                    <div class="col-lg-3 col-md-4 col-6">
                                        @include('client.partials.product-card', ['product' => $product])
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                            @endforeach
                            <div class="text-center">
                                <a type="button" href="{{ route('client.shop').'?cat1='.$category["id"] }}" class="btn btn-sm btn-fill-out">Xem thêm</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr />
    @endforeach


    
    {{-- <!-- START SECTION BANNER -->
    <div class="section pb_20 small_pt">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="sale-banner mb-3 mb-md-4">
                        <a class="hover_effect1" href="#">
                            <img src="assets/images/shop_banner_img11.png" alt="shop_banner_img11">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION BANNER --> --}}
    <!-- END SECTION SHOP -->
    <!-- START SECTION CLIENT LOGO -->
    <div class="section small_pt">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading_tab_header">
                        <div class="heading_s2">
                            <h2>Thương hiệu</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="client_logo carousel_slider owl-carousel owl-theme nav_style3" data-dots="false" data-nav="true" data-margin="30" data-loop="true" data-autoplay="true" data-responsive='{"0":{"items": "2"}, "480":{"items": "3"}, "767":{"items": "4"}, "991":{"items": "5"}}'>
                        @foreach ($brands as $brand)
                            <div class="item brand-logo ">
                                <div class="cl_logo">
                                    <a href="{{ route('client.shop').'?brand='.$brand->id }}">
                                        <img src="{{asset($brand->image)}}" alt="cl_logo" />
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION CLIENT LOGO -->
</div>
<!-- END MAIN CONTENT -->
@endsection

@section('js')
<script>
    document.getElementById('navCatContent').classList.add('nav_cat');
</script>
@endsection
