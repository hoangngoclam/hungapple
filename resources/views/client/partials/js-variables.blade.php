<script>
    var SUCCESS_STATUS = <?= config('constants.json_response.SUCCESS_STATUS') ?>;
    var FAIL_STATUS = <?= config('constants.json_response.FAIL_STATUS') ?>;
    var isCartPage = <?= request()->route()->getName() == "client.cart" ? 1 : 0 ?>;

    var csrfToken = "{{ csrf_token(); }}";
    var cartUrl = "{{ route('client.cart') }}";
    var addToCartUrl = "{{ route('client.addToCart') }}";
    var rmFromCartUrl = "{{ route('client.rmFromCart') }}";
    var updateCartQtyUrl = "{{ route('client.updateCartQuantity') }}";
    var shopUrl = "{{ route('client.shop') }}";
                                            
    var checkoutUrl = "{{ Session::get('user') ? route('client.checkout') : route('client.login') }}";

    var deliveryUrl = "{{ route('client.checkout.select.delivery') }}";

    var imageNotFoundUrl = "{{ asset('assets/images/image-not-available-200.jpg') }}";
</script>