<!DOCTYPE html>
<html lang="vi">

<head>
    @if (Route::is('client.home'))
    <!-- SITE TITLE -->
    <title>TStore | Linh kiện - Phụ kiện - Điện thoại -Sửa chưa & Bảo hành</title>
    <meta name="title" content="TStore | Điện thoại - Linh kiện - Phụ kiện - Sửa chữa và bảo hành điện thoại Đà Lạt">
    <meta name="description" content="TStore | Cung cấp các mặt hàng linh kiện, phụ kiện, điện thoại. Đi kèm với dịch vụ như sửa chữa, ép kính, thay thế linh kiện chính hãng chất lượng cao tại Đà Lạt">
    <meta name="keywords" content="Điện thoại, Linh kiện, Phụ kiện giá rẻ, Sửa chữa và bảo hành điện thoại">

    <meta property="og:title" content="TStore | Điện thoại - Linh kiện - Phụ kiện - Sửa chữa và bảo hành điện thoại">
    <meta property="og:description" content="TStore | Cung cấp các mặt hàng linh kiện, phụ kiện, điện thoại. Đi kèm với dịch vụ như sửa chữa, ép kính, thay thế linh kiện chính hãng chất lượng cao tại Đà Lạt">
    <meta property="og:url" content="https://tstore.com.vn">
    <meta property="og:image" content="">
    @elseif(Route::is('client.detail'))
    @php
    $arrSubImage = explode('|', $product->images);
    @endphp
    <title>{{ $product->meta_title }}</title>
    <meta name="title" content="{{ $product->meta_title }}">
    <meta name="description" content="{{ $product->meta_desc }}">
    <meta name="keywords" content="{{ $product->meta_keywords }}">

    <meta property="og:title" content="{{ $product->meta_title }}">
    <meta property="og:description" content="{{ $product->meta_desc }}">
    <meta property="og:url" content="https://tstore.com.vn">
    <meta property="og:image" content="{{ asset($arrSubImage[0]) }}">
    @else
    <title>TStore | Linh kiện - Phụ kiện - Điện thoại -Sửa chưa & Bảo hành</title>
    @endif
    <!-- Meta -->
    <meta charset="utf-8">
    <meta content="Anil z" name="author">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="3LReMnrvkZ44qMz6Lkjf2wz6ERrDSIqpTSDhr3cs">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="copyright" content="TStore">
    <meta name="author" content="TStore">
    <meta http-equiv="audience" content="General">
    <meta name="resource-type" content="Document">
    <meta name="distribution" content="Global">
    <meta content="INDEX,FOLLOW" name="robots">
    <meta name="revisit-after" content="1 days">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="GENERATOR" content="TStore">
    <meta property="og:site_name" content="tstore.com.vn">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="vi_VN">

    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/logo/favicon.png') }}">
    <!-- Animation CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <!-- Latest Bootstrap min CSS -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/simple-line-icons.css') }}">
    <!--- owl carousel CSS-->
    <link rel="stylesheet" href="{{ asset('assets/owlcarousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/owlcarousel/css/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/owlcarousel/css/owl.theme.default.min.css') }}">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <!-- Slick CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick-theme.css') }}">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
</head>

<body>

    <!-- LOADER -->
    <div class="preloader">
        <div class="lds-ellipsis">
            <img src="{{ asset('assets/images/loading_page.gif') }}" alt="">
        </div>
    </div>
    <!-- END LOADER -->

    <!-- Home Popup Section -->
    <!-- <div class="modal fade subscribe_popup" id="onload-popup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                </button>
                <div class="row no-gutters">
                    <div class="col-sm-5">
                    <div class="background_bg h-100" data-img-src="/images/popup_img.jpg"></div>
                    </div>
                    <div class="col-sm-7">
                        <div class="popup_content">
                            <div class="popup-text">
                                <div class="heading_s4">
                                    <h4>Subscribe and Get 25% Discount!</h4>
                                </div>
                                <p>Subscribe to the newsletter to receive updates about new products.</p>
                            </div>
                            <form method="post">
                            <div class="form-group">
                                <input name="email" required type="email" class="form-control rounded-0" placeholder="Enter Your Email">
                                </div>
                                <div class="form-group">
                                <button class="btn btn-fill-line btn-block text-uppercase rounded-0" title="Subscribe" type="submit">Subscribe</button>
                                </div>
                            </form>
                            <div class="chek-form">
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox3" value="">
                                    <label class="form-check-label" for="exampleCheckbox3"><span>Don't show this popup again!</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>
</div> -->
    <!-- End Screen Load Popup Section -->

    <!-- START HEADER -->
    <header class="header_wrap">
        <div class="top-header d-none d-md-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-8">
                        <div class="header_topbar_info">
                            <div class="header_offer">
                                <i class="ti-location-pin"></i>
                                <a href="{{$googleMapURL}}">{{$shopAddress}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-4">
                        <div class="d-flex align-items-center justify-content-center justify-content-md-end">
                            @php
                            $user = null;
                            $user = Session::get('user');
                            @endphp
                            @if ($user == null)
                            <a href="{{ route('client.login') }}">Đăng nhập</a>
                            &nbsp;/&nbsp;
                            <a href="{{ route('client.register') }}">Đăng ký</a>
                            @else
                            <a href="{{ route('client.logout') }}">Đăng xuất</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="middle-header dark_skin">
            <div class="container">
                <div class="nav_block">
                    <a class="navbar-brand" href="{{ route('client.home') }}">
                        <img class="logo_light" src="{{ asset('assets/images/logo/logo_icon_light.png') }}" alt="logo" />
                        <img class="logo_dark" src="{{ asset('assets/images/logo/logo-chuan.png') }}" width="150px" alt="logo" />
                    </a>
                    <div class="contact_phone order-md-last">
                        <a href="tel:{{$shopPhoneNumber}}">
                            <i class="linearicons-phone-wave"></i>
                            <span>{{$shopPhoneNumber}}</span>
                        </a>
                    </div>
                    <div class="product_search_form">
                        <form action="{{ route('client.shop') }}">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="custom_select">
                                        <select id="searchTypeSelect">
                                            <option selected="selected" disabled>Chọn danh mục...</option>
                                            @if (isset($allCategoriesProcessed) && $allCategoriesProcessed)
                                            @foreach ($allCategoriesProcessed as $categoriesLv1)
                                            <option value="{{ $categoriesLv1['id'] }}" data-type="categoryLv1" {{ $categoriesLv1['id'] == request()->get('cat1') ? 'selected' : '' }}>
                                                {{ $categoriesLv1['name'] }}
                                            </option>
                                            @if (isset($categoriesLv1['categoriesLv2']) && $categoriesLv1['categoriesLv2'])
                                            @foreach ($categoriesLv1['categoriesLv2'] as $categoryLv2)
                                            <option value="{{ $categoryLv2['id'] }}" data-type="categoryLv2" {{ $categoryLv2['id'] == request()->get('cat2') ? 'selected' : '' }}>
                                                &nbsp;&nbsp;&nbsp;{{ $categoryLv2['name'] }}</option>
                                            @endforeach
                                            @endif
                                            @endforeach
                                            @endif
                                        </select>
                                        <input type="hidden" name="" id="searchTypeInput">
                                    </div>
                                </div>
                                <input class="form-control" placeholder="Tìm kiếm sản phẩm ..." required="" type="text" name="keyword" value="{{ request()->get('keyword') }}">
                                <button type="submit" class="search_btn"><i class="linearicons-magnifier"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom_header light_skin main_menu_uppercase bg_dark mb-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-3">
                        <div class="categories_wrap">
                            <button type="button" data-toggle="collapse" data-target="#navCatContent" aria-expanded="false" class="categories_btn">
                                <i class="linearicons-menu"></i><span>Danh mục </span>
                            </button>
                            <div id="navCatContent" class="navbar collapse">

                                <ul>
                                    @if($listAllCategory)
                                    @foreach($listAllCategory as $parentCategory)
                                    <li class="dropdown dropdown-mega-menu">
                                        @if($parentCategory["type"] == "product")
                                        <a class="dropdown-item nav-link {{count($parentCategory["childrenCategory"]) > 0 ? "dropdown-toggler": ""}}" href="{{ route('client.shop').'?cat1='.$parentCategory["id"] }}" data-toggle="dropdown">
                                            <span>{{$parentCategory["name"]}}</span>
                                        </a>
                                        @else
                                        <a class="dropdown-item nav-link
                                                    {{count($parentCategory["childrenCategory"]) > 0 ? "dropdown-toggler": ""}}" href="{{ route('client.shop').'?cat1='.$parentCategory["id"] }}" data-toggle="dropdown">
                                            <span>{{$parentCategory["name"]}}</span>
                                        </a>
                                        @endif
                                        @if(count($parentCategory["childrenCategory"]) > 0)
                                        <div class="dropdown-menu">
                                            <ul class="mega-menu d-lg-flex">
                                                <li class="mega-menu-col col-lg-4">
                                                    <ul class="d-lg-flex">
                                                        <li class="mega-menu-col col-lg-6">
                                                            <ul>
                                                                @foreach($parentCategory["childrenCategory"] as $childCategory)
                                                                <li>
                                                                    @if($parentCategory["type"] == "product")
                                                                    <a class="dropdown-item nav-link nav_item" href="{{ route('client.shop') . '?cat2=' . $childCategory["id"] }}">
                                                                        <span>{{$childCategory["name"]}}</span>
                                                                    </a>
                                                                    @else
                                                                    <a class="dropdown-item nav-link nav_item" href="{{ route('client.serviceShop') . '?cat2=' . $childCategory["id"] }}">
                                                                        <span>{{$childCategory["name"]}}</span>
                                                                    </a>
                                                                    @endif
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                        @endif

                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-9">
                        <nav class="navbar navbar-expand-lg">
                            <button class="navbar-toggler side_navbar_toggler" type="button" data-toggle="collapse" data-target="#navbarSidetoggle" aria-expanded="false">
                                <span class="ion-android-menu"></span>
                            </button>
                            <div class="collapse navbar-collapse mobile_side_menu" id="navbarSidetoggle">
                                <ul class="navbar-nav">
                                    <li><a class="nav-link nav_item" href="{{ route('client.home') }}">Trang chủ</a>
                                    </li>
                                    <li class="dropdown dropdown-mega-menu">
                                        <a class="dropdown-toggle nav-link" href="{{ route('client.shop') }}" data-toggle="dropdown">
                                            Sản phẩm
                                        </a>
                                        <div class="dropdown-menu">
                                            <ul class="mega-menu d-lg-flex">
                                                @if (isset($productCategorys) && $productCategorys)
                                                <li class="mega-menu-col col-lg-4">
                                                    <ul>
                                                        <li>
                                                            <a class="dropdown-item nav-link nav_item" href="{{ route('client.shop') }}">Tất cả</a>
                                                        </li>
                                                        <!-- <li class="dropdown-header" style="color: #ffd400;">Iphone</li> -->
                                                        @foreach ($productCategorys as $productCategory)
                                                        <li><a class="dropdown-item nav-link nav_item" href="{{ route('client.shop') . '?cat1=' . $productCategory["id"] }}">{{ $productCategory["name"] }}</a>
                                                        </li>
                                                        @endforeach

                                                    </ul>
                                                </li>
                                                @endif

                                            </ul>
                                        </div>
                                    </li>

                                    <li>
                                        <a class="nav-link nav_item" href="{{ route('client.contact') }}">
                                            Liên hệ
                                        </a>
                                    </li>

                                </ul>
                            </div>
                            <ul class="navbar-nav attr-nav align-items-center">
                                <!-- <li><a href="#" class="nav-link"><i class="linearicons-user"></i></a></li>
                            <li><a href="#" class="nav-link"><i class="linearicons-heart"></i><span class="wishlist_count">0</span></a></li> -->
                                <li class="dropdown cart_dropdown">
                                    @php
                                    $totalQty = 0;
                                    foreach (Cart::content() as $cartItem) {
                                    $totalQty = $totalQty + intval($cartItem->qty);
                                    }
                                    @endphp
                                    <a class="nav-link cart_trigger" href="#" data-toggle="dropdown">
                                        <i class="linearicons-cart"></i><span class="cart_count">{{ $totalQty }}</span>
                                    </a>
                                    <div class="cart_box dropdown-menu dropdown-menu-right">
                                        @if (count(Cart::content()))
                                        <ul class="cart_list">
                                            @foreach (Cart::content() as $cartItem)
                                            <li>
                                                <a data-rowid="{{ $cartItem->rowId }}" href="javascript:void(0)" class="item_remove" data-type="rmFromCartBtn"><i class="ion-close"></i></a>
                                                <a href="#"><img src="{{ asset('assets/images/cart_thamb1.jpg') }}" alt="cart_thumb1">{{ $cartItem->name }}</a>
                                                <span class="cart_quantity"> {{ (int) $cartItem->qty }} x
                                                    <span class="cart_amount"> <span class="price_symbole"></span></span>{{ number_format((float) $cartItem->price, 0, '', '.') }}
                                                    VND</span>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <div class="cart_footer">
                                            <p class="cart_total"><strong>Tổng giá:</strong> <span class="cart_price">{{ number_format(floatval(str_replace([','], '', Cart::subtotal())), 0, '', '.') }}
                                                    VND<span class="price_symbole"></span></span></p>
                                            <p class="cart_buttons"><a href="{{ route('client.cart') }}" class="btn btn-fill-line view-cart">Giỏ hàng</a>

                                                @if (Session::get('user'))
                                                <a href="{{ route('client.checkout') }}" class="btn btn-fill-out checkout">thanh toán</a>
                                                @else
                                                <a href="{{ route('client.login') }}" class="btn btn-fill-out checkout">thanh toán</a>
                                                @endif
                                                <!-- <a href="{{ route('client.checkout') }}" class="btn btn-fill-out checkout">Thanh toán</a> -->

                                            </p>
                                        </div>
                                        @else
                                        <div class="cart-empty cart-empty-list"><i class="linearicons-cart-empty"></i>
                                            <div>Giỏ hàng của bạn hiện đang trống</div>
                                        </div>
                                        @endif
                                    </div>
                                </li>
                            </ul>
                            <div class="pr_search_icon">
                                <a href="javascript:void(0);" class="nav-link pr_search_trigger"><i class="linearicons-magnifier"></i></a>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- END HEADER -->

    <!-- START CONTENT -->
    @yield('content')
    <!-- END CONTENT -->


    <!-- START FOOTER -->
    <footer class="footer_dark">
        <div class="footer_top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-6 col-sm-12">
                        <div class="widget">
                            <h6 class="widget_title">Thông tin liên hệ</h6>
                            <ul class="contact_info contact_info_light">
                                <li>
                                    <i class="ti-location-pin"></i>
                                    <a href="{{$googleMapURL}}">{{$shopAddress}}</a>
                                </li>
                                <li>
                                    <i class="ti-email"></i>
                                    <a href="mailto:info@sitename.com">{{$shopEmail}}</a>
                                </li>
                                <li>
                                    <i class="ti-mobile"></i>
                                    <a href="tel:{{$shopPhoneNumber}}">{{$shopPhoneNumber}}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="widget">
                            <ul class="social_icons rounded_social">
                                <li><a href="#" class="sc_facebook"><i class="ion-social-facebook"></i></a></li>
                                <li><a href="#" class="sc_twitter"><i class="ion-social-twitter"></i></a></li>
                                <li><a href="#" class="sc_google"><i class="ion-social-googleplus"></i></a></li>
                                <li><a href="#" class="sc_youtube"><i class="ion-social-youtube-outline"></i></a>
                                </li>
                                <li><a href="#" class="sc_instagram"><i class="ion-social-instagram-outline"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="widget">
                            <h6 class="widget_title">Chính sách cửa hàng</h6>
                            <ul class="widget_links">
                                <li><a href="#">Chính sách thanh toán</a></li>
                                <li><a href="#"> Chính sách vận chuyển và giao nhận</a></li>
                                <li><a href="#">Chính sách đổi trả, hoàn tiền</a></li>
                                <li><a href="#">Chính sách bảo hành</a></li>
                                <li><a href="#">Chính sách bảo mật thông tin</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="widget">
                            <h6 class="widget_title">Đăng ký để nhận thông báo</h6>
                            <p>Nếu bạn muốn nhận email từ chúng tôi mỗi khi chúng tôi có ưu đãi đặc biệt mới, hãy đăng
                                ký tại đây!</p>
                            <div class="newsletter_form rounded_input">
                                <form>
                                    <input type="text" required="" class="form-control" placeholder="Nhập địa chỉ Email">
                                    <button class="btn-send" name="submit" value="Submit"><i class="icon-envelope-letter"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom_footer border-top-tran">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-md-0 text-center text-md-left">© 2022 TStore Đăng ký bản quyền </p>
                    </div>
                    <div class="col-md-6">
                        <ul class="footer_payment text-center text-md-right">
                            <li><a href="#"><img src="{{ asset('assets/images/visa.png') }}" alt="visa"></a></li>
                            <li><a href="#"><img src="{{ asset('assets/images/discover.png') }}" alt="discover"></a>
                            </li>
                            <li><a href="#"><img src="{{ asset('assets/images/master_card.png') }}" alt="master_card"></a></li>
                            <li><a href="#"><img src="{{ asset('assets/images/paypal.png') }}" alt="paypal"></a></li>
                            <li><a href="#"><img src="{{ asset('assets/images/amarican_express.png') }}" alt="amarican_express"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- END FOOTER -->

    <a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a>

    <!-- Latest jQuery -->
    <script src="{{ asset('assets/js/jquery-1.12.4.min.js') }}"></script>
    <!-- popper min js -->
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <!-- Latest compiled and minified Bootstrap -->
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- owl-carousel min js  -->
    <script src="{{ asset('assets/owlcarousel/js/owl.carousel.min.js') }}"></script>
    <!-- magnific-popup min js  -->
    <script src="{{ asset('assets/js/magnific-popup.min.js') }}"></script>
    <!-- waypoints min js  -->
    <script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
    <!-- parallax js  -->
    <script src="{{ asset('assets/js/parallax.js') }}"></script>
    <!-- countdown js  -->
    <script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
    <!-- imagesloaded js -->
    <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <!-- isotope min js -->
    <script src="{{ asset('assets/js/isotope.min.js') }}"></script>
    <!-- jquery.dd.min js -->
    <script src="{{ asset('assets/js/jquery.dd.min.js') }}"></script>
    <!-- slick js -->
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <!-- elevatezoom js -->
    <script src="{{ asset('assets/js/jquery.elevatezoom.js') }}"></script>

    {{-- <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- scripts js -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

    <script src="{{ asset('assets/js/utils.js') }}"></script>

    <script src="{{ asset('assets/js/cart.js') }}"></script>

    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script>
        // START Handle for type search select
        var searchParams = new URLSearchParams(window.location.search);
        var params = [];
        for (var param of searchParams) {
            params[param[0]] = param[1];
        }

        function encodeQueryData(data) {
            const ret = [];
            for (let d in data)
                if (data[d] !== '') {
                    ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
                }
            return ret.join('&');
        }
        // Sort by type
        var searchTypeSelect = document.getElementById("searchTypeSelect");
        var searchTypeInput = document.getElementById("searchTypeInput");
        searchTypeSelect.addEventListener('change',
            function(event) {
                var type = event.target.options[event.target.selectedIndex].dataset.type;
                if (type == 'categoryLv1') {
                    searchTypeInput.name = 'cat1';
                } else if (type == 'categoryLv2') {
                    searchTypeInput.name = 'cat2';
                }
                searchTypeInput.value = this.value;
                // var querystring = encodeQueryData(params);
                // window.location = window.location.origin + window.location.pathname + '?' + querystring;
            });
        // END Handle for type search select
    </script>

    @include('client.partials.js-variables')
    <!-- Javascript for each page -->
    @yield('js')

</body>

</html>