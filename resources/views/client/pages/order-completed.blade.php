@extends('client.master')
@section('content')
<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="text-center order_complete">
                        <i class="fas fa-check-circle"></i>
                        <div class="heading_s1">
                            <h3>Đặt hàng thành công!</h3>
                        </div>
                        <p>Cảm ơn bạn đã đặt hàng! Chúng tôi sẽ liên hệ với bạn để xác nhận đơn hàng đã được gửi đi.</p>
                        <a href="{{route('client.home')}}" class="btn btn-fill-out">Tiếp tục mua sắm</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->
</div>
<!-- END MAIN CONTENT -->
@endsection