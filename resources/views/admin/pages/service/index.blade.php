@extends('admin.master')
@section('style')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
        rel="stylesheet">
    <link href="{{ url('admin/assets/libs/toastr/build/toastr.min.css') }}" rel="stylesheet">
    <style>
        .dataTables_processing {
            padding: 0 !important;
            box-shadow: 0 4px 8px 0 rgb(0 0 0 / 20%), 0 6px 20px 0 rgb(0 0 0 / 19%);
        }

        .image-thumb-group {
            display: flex;
        }

        .image-thumb-wrapper {
            position: relative;
            margin-right: 10px;
        }

        .image-thumb {
            padding: .25rem;
            background-color: #eef5f9;
            border: 1px solid #dee2e6;
            border-radius: 2px;
        }

        .image-thumb.big {
            position: absolute;
            top: -180px;
            left: 50%;
            opacity: 0;
            display: none;
            -webkit-transition: all 0.3s linear;
            transition: all 0.3s linear;
            z-index: 999;
        }

        .image-thumb.small:hover+.image-thumb.big {
            display: inline-block;
            opacity: 1;
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
                            <h4 class="card-title">Danh sách dịch vụ</h4>
                            <div class="ml-auto">
                                <div class="btn-group">
                                    <a type="button" class="btn btn-info" href="{{ route('admin.addServiceGet') }}">
                                        Thêm dịch vụ
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="offset-9 col-3">
                                <div class="form-group">
                                    <label class="control-label" for="categoryId">Lọc theo danh mục</label>
                                    <select class="form-control" id="searchTypeSelect">
                                        <option selected="selected" disabled>Chọn danh mục...</option>
                                        @if (isset($allCategoriesProcessed) && $allCategoriesProcessed)
                                            @foreach ($allCategoriesProcessed as $categoriesLv1)
                                                <option value="{{ $categoriesLv1['id'] }}" data-type="categoryLv1"
                                                    {{ $categoriesLv1['id'] == request()->get('cat1') ? 'selected' : '' }}>
                                                    {{ $categoriesLv1['name'] }}</option>
                                                @if (isset($categoriesLv1['categoriesLv2']) && $categoriesLv1['categoriesLv2'])
                                                    @foreach ($categoriesLv1['categoriesLv2'] as $categoryLv2)
                                                        <option value="{{ $categoryLv2['id'] }}" data-type="categoryLv2"
                                                            {{ $categoryLv2['id'] == request()->get('cat2') ? 'selected' : '' }}>
                                                            &nbsp;&nbsp;&nbsp;{{ $categoryLv2['name'] }}</option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    <input type="hidden" name="catType" id="categoryType">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button type="button" class="btn btn-dark ml-auto mb-3" id="btnReset">
                                Đặt lại
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped table-bordered data-table" style="width:100%">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>#ID</th>
                                            <th>Tên</th>
                                            <th>Hình ảnh</th>
                                            <th>Danh mục</th>
                                            <th>Giá</th>
                                            <th>Trạng thái</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    {{-- <tbody>
                                    @if (isset($products) && $products)
                                    @foreach ($products as $product)
                                    <tr>
                                        <td>{{$product->name}}</td>
                                <td>
                                    @if (!empty($product->images))
                                    @php
                                    $arrSubImage = explode("|", $product->images);
                                    @endphp
                                    @foreach ($arrSubImage as $image)
                                    <img src="{{url($image)}}" alt="iPhone" width="80">
                                    @endforeach
                                    @else
                                    <img src="{{ $product->getFirstMediaUrl('product') ? $product->getFirstMediaUrl('product') : '' }}" width="80">
                                    @endif
                                </td>
                                <td>
                                    {{$product->categoryId}}
                                    &#187;
                                    {{$product->categoryIdLv2}}
                                </td>
                                <td>
                                    {{number_format($product->price, 0, '', '.')}} VND
                                    <hr>
                                    Giá khuyến mãi: {{number_format($product->promotionPrice, 0, '', '.')}} VNĐ
                                    <hr>
                                    Giá kĩ thuật: {{number_format($product->technicalPrice, 0, '', '.')}} VNĐ
                                </td>
                                <td>{{$product->quantity}}</td>
                                <td>
                                    <a href="{{route('admin.editProductGet',['id'=>$product->id])}}" class="text-inverse pr-2" data-toggle="tooltip" title="Chỉnh sửa"><i class="ti-marker-alt"></i></a>
                                    <a href="javascript:void(0);" class="text-inverse btn-delete" title="Xóa" data-toggle="tooltip" data-id="{{$product->id}}"><i class="ti-trash" style="pointer-events: none;"></i></a>
                                </td>
                                </tr> @endforeach
                                @else
                                <tr>
                                    <td>No data</td>
                                </tr>
                                @endif

                                </tbody> --}}
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
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script src="{{ url('admin/assets/libs/toastr/build/toastr.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('.data-table').removeAttr('width').DataTable({
                language: {
                    // url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json',
                    "decimal": "",
                    "emptyTable": "Không có dữ liệu",
                    "info": "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                    "infoEmpty": "Hiển thị 0 đến 0 của 0 mục",
                    "infoFiltered": "(được lọc từ _MAX_ tổng số mục)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Hiển thị _MENU_ mục",
                    "loadingRecords": "Đang tải dữ liệu...",
                    "processing": "Đang tải dữ liệu...",
                    "search": "Tìm kiếm theo tên:",
                    "zeroRecords": "Không tìm thấy kết quả phù hợp",
                    "paginate": {
                        "first": "Đầu tiền",
                        "last": "Cuối cùng",
                        "next": "Sau",
                        "previous": "Trước"
                    },
                    "aria": {
                        "sortAscending": ": kích hoạt để sắp xếp cột tăng dần",
                        "sortDescending": ": kích hoạt để sắp xếp cột giảm dần"
                    },
                    "processing": `<button class="btn" type="button" disabled="">
                                          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                          Đang tải dữ liệu...
                                        </button>`,
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.service') }}",
                    data: function(d) {
                        d.catType = $('#categoryType').val();
                    }
                },
                fnDrawCallback: function() {
                    $(".chkToggle").each(function() {
                        $(this).bootstrapToggle();
                        var toggle = this;
                        $(this.parentElement).click(function(e) {
                            e.stopPropagation();
                            console.log(toggle);
                            var updateStatus = 1; // Hiện
                            if (toggle.checked) { // Ẩn
                                updateStatus = 0;
                            }
                            var url = "{{ route('admin.changeServiceStatus') }}";
                            var formData = new FormData();
                            formData.append("id", toggle.dataset.id);
                            formData.append("status", updateStatus);
                            formData.append("_token", "{{ csrf_token() }}");
                            $.ajax({
                                url: url,
                                cache: false,
                                contentType: false,
                                processData: false,
                                data: formData,
                                type: "POST",
                                success: function(data) {
                                    const {
                                        msg
                                    } = data;
                                    if (msg == 'success') {
                                        console.log('success');
                                        $(toggle).bootstrapToggle('toggle')
                                        toastr.success(
                                            'Thay đổi trạng thái dịch vụ thành công!',
                                            'Thành công', {
                                                "closeButton": true
                                            });
                                    } else {
                                        console.error('fail');
                                        toastr.error(
                                            'Thay đổi trạng thái dịch vụ thành công!',
                                            'Thành công', {
                                                "closeButton": true
                                            });
                                    }
                                },
                                error: function(data) {
                                    console.error(data);
                                    toastr.error(
                                        'Thay đổi trạng thái dịch vụ thất bại!',
                                        'Thành công', {
                                            "closeButton": true
                                        });
                                }
                            });
                        });
                    })
                },
                preDrawCallback: function() {
                    console.log('preDrawCallback');
                },
                columns: [
                    {
                        data: 'id',
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: 'images',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'category',
                        orderable: false,
                    },
                    {
                        data: 'price',
                    },
                    {
                        data: 'status',
                        searchable: false
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
            var searchTypeSelect = document.getElementById("searchTypeSelect");
            var categoryType = document.getElementById("categoryType");
            searchTypeSelect.addEventListener('change',
                function(event) {
                    var type = event.target.options[event.target.selectedIndex].dataset.type;
                    if (type == 'categoryLv1') {
                        categoryType.value = 'cat1';
                    } else if (type == 'categoryLv2') {
                        categoryType.value = 'cat2';
                    }
                    // Call ajax for search by category
                    table
                        .column(2)
                        .search(this.value)
                        .draw();
                });
            document.getElementById("btnReset").addEventListener('click', function() {
                searchTypeSelect.selectedIndex = null;
                $('#DataTables_Table_0_filter input[type="search"]').val('');
                $('#categoryType').val('');
                table.ajax.reload();
            })
        });

        function deleteService(event) {
            const confirm = window.confirm('Bạn có chắc muốn xóa dịch vụ này không?')
            if(confirm){
                const productId = event.target.dataset.id;
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.deleteServicePost') }}",
                    data: {id: productId},
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $("td:contains('"+response.id+"')").parent("tr").remove()
                    },
                    fail: function (error){
                        console.log("error:", error);
                    }
                });
            }
        }
    </script>
@endsection
