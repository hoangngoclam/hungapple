@extends('admin.master')
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if (Session::has('fail'))
        <div class="alert alert-danger">{{ Session::get('fail') }}</div>
    @endif
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
                                    <a type="button" class="btn btn-dark" href="{{route('admin.addOrderGet')}}">
                                        Thêm đơn hàng
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
                                            <th>Ngày tạo</th>
                                            <th>Id Tài khoản</th>
                                            <th>Họ tên</th>
                                            <th>Số điện thoại</th>
                                            <th>Địa chỉ</th>
                                            <th>Ghi chú</th>
                                            <th>Thanh toán</th>
                                            <th>Trạng thái</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($orders) && $orders)
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ $order->created_at }}</td>
                                                    <td>{{ $order->userId }}</td>
                                                    <td>{{ $order->nameUser }}</td>
                                                    <td>{{ $order->phoneNumber }}</td>
                                                    <td>{{ $order->address }}</td>
                                                    <td>{{ $order->infoAdd }}</td>
                                                    <td>{{ $order->payment_method == 1 ? 'Trả sau' : 'Chuyển khoản' }}</td>
                                                    <td>
                                                        @if ($order->status == 1 )
                                                            <span class="badge badge-warning">Nhận đơn</span>
                                                        @elseif ($order->status == 0)
                                                            <span class="badge badge-danger">Hủy đơn</span>
                                                        @else
                                                            <span class="badge badge-success">Chốt đơn</span>
                                                        @endif
                                                    <td>
                                                        <div style="width: 150px">
                                                            <a href="{{route('admin.orderDetail',['id'=>$order->id])}}" class="btn btn-success pr-2" data-toggle="tooltip" title="Chi tiết đơn hàng" target="_blank"><i class=" ti-eye"></i></a>
                                                            <a href="{{route('admin.editOrderGet',['id'=>$order->id])}}" class="btn btn-warning pr-2" data-toggle="tooltip" title="Chỉnh sửa" target="_blank"><i class="ti-marker-alt"></i></a>
                                                            <a href="javascript:void(0);" class="btn btn-danger btn-delete" title="Xóa" data-id="{{ $order->id }}"  data-toggle="tooltip" title="Xoá"><i class="ti-trash" style="pointer-events: none;"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>No data</td>
                                            </tr>
                                        @endif

                                    </tbody>
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
            form.action = "{{ route('admin.deleteOrder') }}";
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
                var dialog = confirm('Xác nhận xóa đơn hàng');
                if (dialog == true) {
                    deleteEntry(this.dataset.id);
                }
            })
        });
    </script>
@endsection
