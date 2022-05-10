@extends('client.master')
@section('content')
@php
$countQuantityCart = 0;
$total = 0;
$cart = null;
$fee_shipping = 25000;
// if(Session::get('cart')){
//     $cart = Session::get('cart');
//     foreach ($cart as $item) {
//         $total += $item['quantity'] * $item['product']->promotionPrice;
//     }
// }else {
//     $countQuantityCart = 0;
// }
@endphp

<div class="section">
	<div class="container">
        <form method="post" action="{{route('client.postCheckout')}}">
            <div class="row">
                <div class="col-md-5">
                    <div class="heading_s1">
                        <h4>Thông tin đặt hàng</h4>
                    </div>

                        <div class="form-group">
                            <input type="text" required class="form-control" name="name" placeholder="Tên khách hàng *">
                        </div>
                        <div class="form-group">
                            <input type="number" required class="form-control" name="phone" placeholder="Số điện thoại *">
                        </div>
                        <div class="form-group">
                            <div class="custom_select">
                                <select name="province" id="province" required class="form-control choose province">
                                    <option value="">Tỉnh/ Thành phố *</option>
                                    @foreach ($listProvince as $province)
                                        <option value="{{$province->matp}}">{{$province->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom_select">
                                <select name="district" required id="district" class="form-control choose district">
                                    <option value="">Quận/ Huyện *</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom_select">
                                <select name="ward" id="ward" required class="form-control ward">
                                    <option value="">Phường/ Xã *</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="billing_address" required="" placeholder="Địa chỉ nhận hàng *">
                        </div>
                        <div class="heading_s1">
                            <h4>Thêm thông tin</h4>
                        </div>
                        <div class="form-group mb-0">
                            <textarea name="info_add" rows="5" class="form-control" placeholder="Ghi chú đơn hàng"></textarea>
                        </div>

                </div>
                <div class="col-md-7">
                    <div class="order_review" style="padding-top: 0">
                        <div class="heading_s1">
                            <h4>Đơn đặt hàng</h4>
                        </div>
                        <div class="table-responsive order_table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Giá x Số Lượng</th>
                                        <th>Tổng cộng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Cart::content() as $cartItem)
                                        <tr>
                                            <td><span>{{$cartItem->name}}</span></td>
                                            <td>{{number_format(($cartItem->price), 0, '', '.')}}<span class="product-qty"> x {{$cartItem->qty}}</span></td>
                                            <td>{{number_format(($cartItem->price * (int)$cartItem->qty), 0, '', '.')}} VNĐ</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Tạm tính</th>
                                        <td class="product-subtotal">{{number_format(floatval(str_replace(array(','), '', Cart::subtotal())), 0, '', '.')}} VND</td>
                                    </tr>
                                    <tr>
                                        <th>Phí vận chuyển</th>
                                        <td>{{number_format(config('constants.order.SHIPPING_FEE'), 0, '', '.')}} VND</td>
                                    </tr>
                                    <tr>
                                        <th>Tổng cộng</th>
                                        <td class="product-subtotal">{{number_format(floatval(str_replace(array(','), '', Cart::subtotal())+
                                            config('constants.order.SHIPPING_FEE')), 0, '', '.')}} VND</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="payment_method">
                            <div class="heading_s1">
                                <h4>Phương Thức Thanh toán</h4>
                            </div>
                            <div class="payment_option">
                                <div class="custome-radio">
                                    <input class="form-check-input" type="radio" name="payment_option" id="exampleRadios2" value="{{config('constants.payment_method.POSTPAID')}}" checked>
                                    <label class="form-check-label" for="exampleRadios2">Kiểm tra thanh toán</label>
                                    <p data-method="{{config('constants.payment_method.POSTPAID')}}" class="payment-text">Quý khách được xem hàng trước khi thanh toán</p>
                                </div>

                                <div class="custome-radio">
                                    <input class="form-check-input" type="radio" name="payment_option" id="exampleRadios1" value="{{config('constants.payment_method.TRANSFER')}}" >
                                    <label class="form-check-label" for="exampleRadios1">Chuyển khoản trực tiếp</label>
                                    <p data-method="{{config('constants.payment_method.TRANSFER')}}" class="payment-text">Chúng tôi sẽ liên hệ với quý khách và thanh toán bằng cách chuyển khoản qua STK: 123456789, Tên tài khoản: TStore</p>
                                </div>
                            </div>
                        </div>
                        @csrf
                        <button type="submit" class="btn btn-fill-out btn-block">Đặt hàng</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
