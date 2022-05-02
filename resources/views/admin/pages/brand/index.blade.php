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
                            <h4 class="card-title">Danh sách danh mục</h4>
                            <div class="ml-auto">
                                <div class="btn-group">
                                    <a type="button" class="btn btn-dark" href="{{route('admin.addBrandGet')}}">
                                        Thêm thương hiệu
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
                                            <th>Tên</th>
                                            <th>Hình ảnh</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($brands) && $brands)
                                            @foreach ($brands as $brand)
                                                <tr>
                                                    <td>{{ $brand->id }}</td>
                                                    <td>{{ $brand->name }}</td>
                                                    <td><img src="{{asset( $brand->image)}}" width="200x" alt=""></td>
                                                    <td>
                                                        <a href="{{route('admin.editBrandGet',['id'=>$brand->id])}}" class="btn btn-warning pr-2" data-toggle="tooltip" title="Chỉnh sửa"><i class="ti-marker-alt"></i></a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-delete" title="Xóa" data-id="{{ $brand->id }}"  data-toggle="tooltip" title="Xoá"><i class="ti-trash" style="pointer-events: none;"></i></a>
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
            form.action = "{{ route('admin.deleteBrand') }}";
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
                var dialog = confirm('Xác nhận xóa thương hiệu');
                if (dialog == true) {
                    deleteEntry(this.dataset.id);
                }
            })
        });
    </script>
@endsection
