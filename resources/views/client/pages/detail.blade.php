@extends('client.master')
@section('content')
<!-- START MAIN CONTENT -->
<div class="main_content">
    @php
    $arrSubImage = $product->getMedia('images');
    @endphp
    <!-- START SECTION SHOP -->
    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                    <div class="product-image">
                        <div class="product_img_box">
                            <img id="product_img" src="{{ $product->getFirstMediaUrl('images') }}" data-zoom-image="{{ $product->getFirstMediaUrl('images') }}" alt="{{$product->name}}" onerror="this.onerror=null;this.src='{{ asset('assets/images/image-not-available.jpg') }}';" />
                        </div>
                        <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-slides-to-show="4" data-slides-to-scroll="1" data-infinite="false">
                            @foreach ($arrSubImage as $image)
                            <div class="item">
                                <a href="#" class="product_gallery_item active" data-image="{{$image->getUrl()}}" data-zoom-image="{{$image->getUrl()}}">
                                    <img src="{{$image->getUrl('thumb')}}" alt="{{$product->name}}" onerror="this.onerror=null;this.src='{{ asset('assets/images/image-not-available.jpg') }}';" />
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="pr_detail">
                        <div class="product_description">
                            <h4 class="product_title"><a href="{{route('client.detail',['id'=> $product->id])}}">{{$product->name}}</a></h4>
                            <div class="product_price">
                                @if($product->promotionPrice > 0)
                                <span class="price">{{number_format($product->promotionPrice, 0, '', '.')}} VNĐ</span>
                                <div>
                                    <del>{{number_format($product->price, 0, '', '.')}} VNĐ</del>
                                    <div class="on_sale">
                                        <span>Giảm {{ceil(100 - ($product->promotionPrice/$product->price)*100)}}%</span>
                                    </div>
                                </div>
                                @else
                                <span class="price">{{number_format($product->promotionPrice, 0, '', '.')}} VNĐ</span>
                                @endif
                                <div class="rating_wrap">
                                    <div class="rating">
                                        <div class="product_rate" style="width:80%"></div>
                                    </div>
                                    <span class="rating_num"></span>
                                </div>
                            </div>

                            <div class="pr_desc">
                                {{-- <p>{{$product->meta_desc}}</p> --}}
                                <p>123123</p>
                            </div>
                            <div class="product_sort_info">
                                <ul>
                                    <li><i class="linearicons-shield-check"></i> Bảo hành thương hiệu</li>
                                    <li><i class="linearicons-sync"></i> Chính sách hoàn trả khi lỗi do nhà sản xuất.</li>
                                    <li><i class="linearicons-bag-dollar"></i> Thanh toán khi giao hàng</li>
                                </ul>
                            </div>
                            {{-- <div class="pr_switch_wrap">
                            <span class="switch_lable">Màu sắc</span>
                            <div class="product_color_switch">
                                <span class="active" data-color="#87554B"></span>
                                <span data-color="#333333333"></span>
                                <span data-color="#DA323F"></span>
                            </div>
                        </div> --}}

                        </div>
                        <hr />
                        <div class="cart_extra">
                            <div class="cart-product-quantity">
                                <div class="quantity">
                                    <input type="button" value="-" class="minus" data-type="minusCartItemBtnQV">
                                    <input id="quantity-quickview-{{$product->id}}" type="text" name="quantity" value="1" title="Qty" class="qty" size="4">
                                    <input type="button" value="+" class="plus" data-type="plusCartItemBtnQV">
                                </div>
                            </div>
                            <div class="cart_btn">
                                <button class="btn btn-fill-out btn-addtocart" onclick="addToCartQuickView({{$product->id}},{{$product->qty}})"><i class="icon-basket-loaded"></i> Thêm vào giỏ</button>
                            </div>
                        </div>
                        <hr />
                        <ul class="product-meta">
                            <li>Sản phẩm hiện có: {{$product->quantity}}</li>
                            {{-- <li>Danh mục: <a href="#">Clothing</a></li>
                        <li>Tags: <a href="#" rel="tag">Điện thoại</a>, <a href="#" rel="tag">Iphone</a> </li> --}}
                        </ul>

                        <div class="product_share">
                            <span>Chia sẻ:</span>
                            <ul class="social_icons">
                                <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
                                <li><a href="#"><i class="ion-social-youtube-outline"></i></a></li>
                                <li><a href="#"><i class="ion-social-instagram-outline"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="large_divider clearfix"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tab-style3">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="Description-tab" data-toggle="tab" href="#Description" role="tab" aria-controls="Description" aria-selected="true">Mô tả chi tiết</a>
                            </li>
                        </ul>
                        <div class="tab-content shop_info_tab">
                            <div class="tab-pane fade show active" id="Description" role="tabpanel" aria-labelledby="Description-tab">
                                {!! $product->desc !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="small_divider"></div>
                    <div class="divider"></div>
                    <div class="medium_divider"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="heading_s1">
                        <h3>Sản phẩm liên quan</h3>
                    </div>
                    <div class="releted_product_slider carousel_slider owl-carousel owl-theme" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
                        @foreach ($productsRelate as $productRelate)
                        <div class="item">
                            @include('client.partials.product-card', ['product' => $productRelate])
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->
    <!-- END SECTION SHOP -->

    <!-- START SECTION SUBSCRIBE NEWSLETTER -->
    {{-- <div class="section bg_default small_pt small_pb">
	<div class="container">
    	<div class="row align-items-center">
            <div class="col-md-6">
                <div class="heading_s1 mb-md-0 heading_light">
                    <h3>Subscribe Our Newsletter</h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="newsletter_form">
                    <form>
                        <input type="text" required="" class="form-control rounded-0" placeholder="Enter Email Address">
                        <button type="submit" class="btn btn-dark rounded-0" name="submit" value="Submit">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
    <!-- START SECTION SUBSCRIBE NEWSLETTER -->

</div>
<!-- END MAIN CONTENT -->
@endsection