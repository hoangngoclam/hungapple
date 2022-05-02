@extends('client.master')
@section('content')
    <!-- START MAIN CONTENT -->
    <div class="main_content">

        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="row align-items-center mb-4 pb-1">
                            <div class="col-12">
                                <div class="product_header">
                                    <div class="product_header_left">
                                        <div class="custom_select">
                                            <select class="form-control form-control-sm" id="sortSelect">
                                                @if (null != config('shop_config.sort_by') && config('shop_config.sort_by'))
                                                    @foreach (config('shop_config.sort_by') as $key => $option)
                                                        <option value="{{ $key }}"
                                                            {{ $key == request()->get('sortBy') ? 'selected' : '' }}>
                                                            {{ $option['text'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="product_header_right">
                                        <div class="products_view">
                                            <a href="javascript:Void(0);" class="shorting_icon grid active"><i
                                                    class="ti-view-grid"></i></a>
                                            <a href="javascript:Void(0);" class="shorting_icon list"><i
                                                    class="ti-layout-list-thumb"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (isset($products) && $products)
                            @if (count($products))
                                <div class="row shop_container grid">
                                    @foreach ($products as $product)
                                        <div class="col-md-4 col-6">
                                            @include('client.partials.product-card', ['product' => $product, 'listLayout' =>
                                            true])
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="shop-empty"><i class="linearicons-find-replace"></i>
                                    <div>Rất tiếc chúng tôi không tìm thấy kết quả theo yêu cầu của bạn.</div>
                                    <a class="btn btn-fill-out mt-3" href="{{ route('client.shop') }}">Về cửa hàng</a>
                                </div>
                            @endif
                        @endif
                        <div class="row">
                            <div class="col-12">
                                {!! $products->appends(request()->input())->links('client.partials.pagination') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 order-lg-first mt-4 pt-2 mt-lg-0 pt-lg-0">
                        <div class="sidebar">
                            @foreach ($productCategorys as $category)
                                <div class="widget">
                                    <h5 class="widget_title">{{$category["name"]}}</h5>
                                    <ul class="widget_categories">
                                        @if (isset($productCategorys) && count($category["childrenCategory"]) > 0)
                                            <li><a class="{{ 2 == request()->get('cat1') ? 'active' : '' }}" data-type="categoryLv1" href="javascript:void(0)"
                                                    data-value="{{$category["id"]}}"><span class="categories_name">Tất cả</span>
                                                    {{-- <span class="categories_num">(6)</span> --}}
                                                </a></li>
                                            @foreach ($category["childrenCategory"] as $categoryChild)
                                                <li><a class="{{ $categoryChild["id"] == request()->get('cat2') ? 'active' : '' }}"
                                                        data-type="categoryLv2" href="javascript:void(0)"
                                                        data-value="{{ $categoryChild['id'] }}"><span
                                                            class="categories_name">{{ $categoryChild["name"] }}</span>
                                                        {{-- <span class="categories_num">(6)</span> --}}
                                                    </a></li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            @endforeach
                            <div class="widget">
                                <h5 class="widget_title">Thương hiệu</h5>
                                <ul class="list_brand">
                                    @if (isset($brands) && $brands)
                                        @php
                                            $brandIds = explode(',', request()->get('brand'));
                                        @endphp
                                        @foreach ($brands as $brand)
                                            <li>
                                                <div class="custome-checkbox">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="{{ $brand->name }}Checkbox" value="{{ $brand->id }}"
                                                        data-type="brand"
                                                        {{ in_array($brand->id, $brandIds) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="{{ $brand->name }}Checkbox"><span>{{ $brand->name }}</span></label>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
    <!-- END MAIN CONTENT -->
@endsection

@section('js')
    <script>
        // START Handle for sort product
        // Sort by type
        var sortSelect = document.getElementById("sortSelect");
        sortSelect.addEventListener('change',
            function() {
                params["sortBy"] = this.value;
                var querystring = encodeQueryData(params);
                window.location = window.location.origin + window.location.pathname + '?' + querystring;
            });
        // END Handle for sort product

        // START Handle for filter brand
        var brandCheckboxes = document.querySelectorAll("input[type='checkbox'][data-type='brand']");

        function getBrandParamsStr() {
            let brandParams = "";
            //Filter by brand
            for (const checkbox of brandCheckboxes) {
                if (checkbox.checked) {
                    brandParams += checkbox.value + ',';
                }
            }
            brandParams = brandParams.slice(0, -1);
            return brandParams;
        }

        for (const checkbox of brandCheckboxes) {
            checkbox.addEventListener('change', function() {
                if (checkbox.checked) {
                    params["brand"] = getBrandParamsStr();
                    const querystring = encodeQueryData(params);
                    window.location = window.location.origin + window.location.pathname + '?' + querystring;
                } else {
                    params["brand"] = getBrandParamsStr();
                    const querystring = encodeQueryData(params);
                    window.location = window.location.origin + window.location.pathname + '?' + querystring;
                }
            })
        }
        // END Handle for filter brand

        // START Handle for category level 2 link
        var categoryLv2Links = document.querySelectorAll("a[data-type='categoryLv2']");

        for (const link of categoryLv2Links) {
            link.addEventListener('click', function() {
                delete params["cat1"];
                params["cat2"] = link.dataset.value;
                const querystring = encodeQueryData(params);
                window.location = window.location.origin + window.location.pathname + '?' + querystring;
            })
        }
        // END Handle for filter brand

        // START Handle for category level 1 link
        var categoryLv1Links = document.querySelectorAll("a[data-type='categoryLv1']");

        for (const link of categoryLv1Links) {
            link.addEventListener('click', function() {
                delete params["cat2"];
                params["cat1"] = link.dataset.value;
                const querystring = encodeQueryData(params);
                window.location = window.location.origin + window.location.pathname + '?' + querystring;
            })
        }
        // END Handle for filter brand
    </script>
@endsection
