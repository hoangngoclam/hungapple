
<div class="product">
    <div class="service_img">
        <a href="{{ route('client.serviceDetail', ['id' => $service->id]) }}">
            <img src="{{ $service->getFirstMediaUrl('images', 'preview') }}" alt="{{ $service->name }}"
                onerror="this.onerror=null;this.src='{{ asset('assets/images/image-not-available.jpg') }}';">
        </a>
    </div>
    <div class="product_info">
        <h6 class="product_title"><a
                href="{{ route('client.serviceDetail', ['id' => $service->id]) }}">{{ $service->name }}</a>
        </h6>
        <div class="product_price">
            <div><span class="price">{{ number_format($service->promotionPrice, 0, '', '.') }} VND</span>
            </div>
            <div><del>{{ number_format($service->price, 0, '', '.') }} VND</del></div>
        </div>
        <div class="rating_wrap">
            <div class="rating">
                <div class="product_rate" style="width:80%"></div>
            </div>
            <span class="rating_num"></span>
        </div>
        <div class="pr_desc">
            <p>{{ $service->meta_desc }}</p>
        </div>
    </div>
</div>
