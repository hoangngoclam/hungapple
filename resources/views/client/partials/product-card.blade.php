<div class="product">
    <div class="product_img">
        <a href="shop-product-detail.html">
            <img src="{{ $product->getFirstMediaUrl('images', 'preview') }}" alt="{{ $product->name }}"
                onerror="this.onerror=null;this.src='{{ asset('assets/images/image-not-available.jpg') }}';">
        </a>
        <div class="product_action_box">
            <ul class="list_none pr_action_btn">
                <li class="add-to-cart">
                    <a data-type="addToCartBtn" href="javascript:void(0)" data-id="{{ $product->id }}">
                        <i class="icon-basket-loaded"></i>
                        Thêm vào giỏ</a>
                </li>
                <li><a href="{{ route('client.quickView', ['id' => $product->id]) }}" class="popup-ajax"><i
                            class="icon-magnifier-add"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="product_info">
        <h6 class="product_title"><a
                href="{{ route('client.detail', ['id' => $product->id]) }}">{{ $product->name }}</a>
        </h6>
        <div class="product_price">
            {{-- <div class="on_sale">
                <span>{{number_format($product->technicalPrice, 0, '', '.')}} VND (Giá KT)</span>
            </div> --}}
            <div><span class="price">{{ number_format($product->promotionPrice, 0, '', '.') }} VND</span>
            </div>
            <div><del>{{ number_format($product->price, 0, '', '.') }} VND</del></div>
        </div>
        <div class="rating_wrap">
            <div class="rating">
                <div class="product_rate" style="width:80%"></div>
            </div>
            <span class="rating_num"></span>
        </div>
        <div class="pr_desc">
            <p>{{ $product->meta_desc }}</p>
        </div>
        @if (isset($listLayout) && $listLayout)
            <div class="list_product_action_box">
                <ul class="list_none pr_action_btn">
                    <li class="add-to-cart"><a data-type="addToCartBtn" data-id="{{ $product->id }}"
                            href="javascript:void(0)"><i class="icon-basket-loaded"></i> Thêm vào giỏ hàng</a></li>
                    <li><a href="{{ route('client.quickView', ['id' => $product->id]) }}" class="popup-ajax"><i
                                class="icon-magnifier-add"></i></a></li>
                </ul>
            </div>
        @endif
    </div>
</div>
