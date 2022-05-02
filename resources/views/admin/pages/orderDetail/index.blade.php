@extends('admin.master')
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if (Session::has('fail'))
        <div class="alert alert-danger">{{ Session::get('fail') }}</div>
    @endif
    @php
        $totalPrice = 0;
    @endphp
    <div class="row">
        <!-- Column -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="d-flex no-block align-items-center mb-4">
                            <h4 class="card-title">Danh sách đơn hàng</h4>
                            <div class="ml-auto">
                                <div class="btn-group">
                                    <a type="button" class="btn btn-dark" href="{{route('admin.addOrderDetailGet',['id'=>$id])}}">
                                        Thêm chi tiết đơn hàng
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="" class="table table-striped table-bordered data-table">

                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>Mã sản phẩm</th>
                                            <th>Ngày tạo</th>

                                            <th>Hình ảnh</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Giá</th>
                                            <th>Số lượng</th>
                                            <th>Tổng giá</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($ordersDetail) && $ordersDetail)
                                            @foreach ($ordersDetail as $orderDetail)
                                                <tr>
                                                    <td>{{ $orderDetail->id }}</td>
                                                    <td>{{ $orderDetail->product->SKU  }}</td>
                                                    <td>{{ $orderDetail->created_at }}</td>
                                                    @php
                                                        $arrSubImage = explode("|", $orderDetail->product->images);
                                                        $totalPrice = $totalPrice + $orderDetail->product->promotionPrice*$orderDetail->quantity;
                                                    @endphp
                                                    <td><img src="{{ asset($arrSubImage[0])}}" width="100px" alt=""></td>
                                                    <td>{{ $orderDetail->product->name  }}</td>
                                                    <td>{{ number_format($orderDetail->product->promotionPrice, 0, '', '.') }} VNĐ</td>
                                                    <td>{{ $orderDetail->quantity }}</td>
                                                    <td>{{ number_format( $orderDetail->product->promotionPrice*$orderDetail->quantity, 0, '', '.') }} VNĐ</td>
                                                    <td>
                                                        <a href="{{route('admin.editOrderDetailGet',['id'=>$orderDetail->id])}}" class="btn btn-warning pr-2" data-toggle="tooltip" title="Chỉnh sửa"><i class="ti-marker-alt"></i></a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-delete" title="Xóa" data-id="{{ $orderDetail->id }}"  data-toggle="tooltip" title="Xoá"><i class="ti-trash" style="pointer-events: none;"></i></a>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>No data</td>
                                            </tr>
                                        @endif

                                    </tbody>

                                    <div style="font-size:25px">Tổng giá đơn hàng: {{ number_format( $totalPrice, 0, '', '.') }} VNĐ</div>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
@endsection
@section('script')
    <script>
        function deleteEntry(id) {
            var form = document.createElement("form");
            document.body.appendChild(form);
            form.method = "POST";
            form.action = "{{ route('admin.deleteOrderDetail') }}";
            var tokenField = document.createElement("input");
            tokenField.name = "_token"
            tokenField.value = "{{ csrf_token() }}";
            tokenField.type = 'hidden'
            form.appendChild(tokenField);
            var idField = document.createElement("input");
            idField.name = "id"
            idField.value = id;
            idField.type = 'hidden'
            form.appendChild(idField);
            form.submit();
        }
        $('.btn-delete').each(function() {
            $(this).on('click', function() {
                var dialog = confirm('Xác nhận xóa chi tiết đơn hàng #id = ' + this.dataset.id);
                if (dialog == true) {
                    deleteEntry(this.dataset.id);
                }
            })
        });
    </script>
@endsection
