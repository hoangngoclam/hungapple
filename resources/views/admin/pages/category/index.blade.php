@extends('admin.master')
@section('style')
    <style>
        .show-flag-checkbox{
            transform: scale(2);
            cursor: pointer;
        }
    </style>
@endsection
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
                                    <a type="button" class="btn btn-dark" href="{{route('admin.addCategoryGet')}}">
                                        Thêm danh mục
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="" class="table table-striped table-bordered data-table">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th># ID</th>
                                            <th>Danh mục cha</th>
                                            <th>Tên danh mục</th>
                                            <th>Hiển thị</th>
                                            <th>meta_title</th>
                                            <th>meta_desc</th>
                                            <th>meta_keywords</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($categories) && $categories)
                                            @foreach ($categories as $category)
                                                <tr>
                                                    <td>{{ $category->id }}</td>
                                                    <td>
                                                        {{ $category->nameParentId }}
                                                    </td>
                                                    <td>{{ $category->name }}</td>
                                                    <td class="text-center">
                                                        @if ($category->show_flag)
                                                            <input class="show-flag-checkbox" type="checkbox" data-id="{{ $category->id }}" checked>
                                                        @else
                                                            <input class="show-flag-checkbox" type="checkbox" data-id="{{ $category->id }}" >
                                                        @endif
                                                    </td>
                                                    <td>{{ $category->meta_title }}</td>
                                                    <td>{{ $category->meta_desc }}</td>
                                                    <td>{{ $category->meta_keywords }}</td>
                                                    <td>
                                                        <a href="{{route('admin.editCategoryGet',['id'=>$category->id])}}" 
                                                            class="btn btn-warning pr-2" data-toggle="tooltip" 
                                                            title="Chỉnh sửa">
                                                            <i class="ti-marker-alt"></i>
                                                        </a>

                                                        <a href="javascript:void(0);" class="btn btn-danger btn-delete" 
                                                        title="Xóa" data-id="{{ $category->id }}"  data-toggle="tooltip" 
                                                        title="Xoá">
                                                            <i class="ti-trash" style="pointer-events: none;"></i>
                                                        </a>
                                                    
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
        var toastMixin = Swal.mixin({
            toast: true,
            title: 'General Title',
            animation: false,
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        function deleteEntry(id) {
            var form = document.createElement("form");
            document.body.appendChild(form);
            form.method = "POST";
            form.action = "{{ route('admin.deleteCategory') }}";
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
                var dialog = confirm('Xác nhận xóa danh mục');
                if (dialog == true) {
                    deleteEntry(this.dataset.id);
                }
            })
        });
        $('.show-flag-checkbox').click(function (e) {
            const payload = {
                id: e.target.dataset.id,
                status: e.target.checked ? 1 : 0
            }
            $.ajax({
                type: "post",
                url: "{{ route('admin.api.updateCategoryStatus') }}",
                data: payload,
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    toastMixin.fire({
                        animation: true,
                        icon: 'success',
                        title: `Update danh mục "${response.name}" thành công`
                    });
                },
                error: function (request, status, error) {
                    toastMixin.fire({
                        animation: true,
                        icon: 'error',
                        title: `Update danh mục thất bại`
                    });
                }
            })
        });
    </script>
@endsection
