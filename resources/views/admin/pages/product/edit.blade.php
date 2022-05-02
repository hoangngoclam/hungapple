@extends('admin.master')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/libs/summernote/dist/summernote-bs4.css') }}">
    <link href="https://releases.transloadit.com/uppy/v2.1.0/uppy.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"
        integrity="sha512-Velp0ebMKjcd9RiCoaHhLXkR1sFoCCWXNp6w4zj1hfMifYB5441C+sKeBl/T/Ka6NjBiRfBBQRaQq65ekYz3UQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #mediaLibraryModal {
            padding-right: 0 !important
        }

        #mediaLibraryModal .modal-body {
            height: 80vh;
            overflow-y: scroll;
        }

        #mediaUploadModal {
            padding-left: 20px;
            padding-right: 20px;
            background-color: rgba(1, 1, 1, 0.4)
        }

        .note-group-select-from-files {
            display: none;
        }

        .image-validate.is-invalid,
        .textarea-validate.is-invalid {
            border: 2px solid #f62d51;
            padding: 5px;
        }

        .image-validate.invalid-feedback,
        .textarea-validate.invalid-feedback {
            display: block !important;
        }

        .invalid-feedback-custom {
            width: 100%;
            margin-top: .25rem;
            font-size: 80%;
            color: #f62d51;
        }

        .preview-image {
            width: 200px;
            height: 200px;
            position: relative;
            margin-right: 15px;
            margin-bottom: 100px;
        }

        .preview-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .btn-remove-image {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            top: -7px;
            right: -7px;
            border-radius: 100%;
            width: 25px;
            height: 25px;
            padding: 5px;
            line-height: 30px;
        }

    </style>
@endsection
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}
            @if (Session::has('productId'))
                <a href="{{ route('client.detail', ['id' => Session::get('productId')]) }}" target="_blank">
                    Xem sản phẩm trên trang
                </a>
            @endif
        </div>
    @endif
    @if (Session::has('fail'))
        <div class="alert alert-danger">{{ Session::get('fail') }}</div>
    @endif
    @if ($errors->product->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->product->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div id="mediaLibraryModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Thư viện ảnh</h4>
                    <button class="btn btn-info ml-auto mr-2" data-toggle="modal" data-target="#mediaUploadModal">
                        <i class="ti-upload"></i>&nbsp;&nbsp;Tải ảnh lên</button>
                    <button style="margin-left:0" type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    Đang tải...
                </div>
                <div class="modal-footer">
                    <button id="mediaLibraryChooseBtn" type="button" class="btn btn-primary waves-effect text-left"
                        style="display:none">Chọn</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div id="mediaUploadModal" class="modal fade mt-3" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Tải ảnh lên</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div id="mediaUploadDropArea"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Trở về</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="row">
        <!-- Column -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form id="form" action="{{ route('admin.editProductPost') }}" method="POST"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $product->id }}" name="id">
                        <div class="form-body">
                            <h5 class="card-title">Thông tin sản phẩm</h5>
                            <div><strong>Chú ý:&nbsp;</strong>Mục<span class="text-danger">&nbsp;*&nbsp;</span>là bắt
                                buộc
                                phải nhập/chọn</div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Tên sản phẩm<span
                                                class="text-danger">&nbsp;*</span></label>
                                        <input type="text" id="name"
                                            class="form-control 
                                    {{ $errors->product->first('name') ? 'is-invalid' : '' }}"
                                            placeholder="Nhập vào" name="name" value="{{ $product->name }}">
                                        @if ($errors->product->first('name'))
                                            <div class="invalid-feedback">
                                                {{ $errors->product->first('name') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!--/row-->
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="categoryId">Danh mục 1<span
                                                class="text-danger">&nbsp;*</span></label>
                                        <select
                                            class="form-control
                                    {{ $errors->product->first('categoryId') ? 'is-invalid' : '' }}"
                                            id="categoryId" name="categoryId">
                                            <option disabled>---Chọn danh mục 1---</option>
                                            @if ($lvl1Categories)
                                                @foreach ($lvl1Categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $category->id == $product->categoryId ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->product->first('categoryId'))
                                            <div class="invalid-feedback">
                                                {{ $errors->product->first('categoryId') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="categoryIdLv2">Danh mục 2<span
                                                class="text-danger">&nbsp;*</span></label>
                                        <select
                                            class="form-control
                                    {{ $errors->product->first('categoryIdLv2') ? 'is-invalid' : '' }}"
                                            id="categoryIdLv2" name="categoryIdLv2">
                                            @if (isset($product->categoryIdLv2))
                                                @foreach ($product->getCategoriesLvl2($product->categoryId) as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $category->id == $product->categoryIdLv2 ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->product->first('categoryIdLv2'))
                                            <div class="invalid-feedback">
                                                {{ $errors->product->first('categoryIdLv2') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="price">Giá<span
                                                class="text-danger">&nbsp;*</span></label>
                                        <div class="input-group mb-3">
                                            <input type="text"
                                                class="form-control
                                        {{ $errors->product->first('price') ? 'is-invalid' : '' }}"
                                                placeholder="Nhập vào" id="price" name="price"
                                                value="{{ $product->price }}">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">VNĐ</span>
                                            </div>
                                            @if ($errors->product->first('price'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->product->first('price') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="promotionPrice">Giảm giá<span
                                                class="text-danger">&nbsp;*</span></label>
                                        <div class="input-group mb-3">
                                            <input type="text"
                                                class="form-control
                                        {{ $errors->product->first('promotionPrice') ? 'is-invalid' : '' }}"
                                                placeholder="Nhập vào" id="promotionPrice" name="promotionPrice"
                                                value="{{ $product->promotionPrice }}">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon2">VNĐ</span>
                                            </div>
                                            @if ($errors->product->first('promotionPrice'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->product->first('promotionPrice') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="technicalPrice">Giá technical</label>
                                        <div class="input-group mb-3">
                                            <input type="text"
                                                class="form-control
                                        {{ $errors->product->first('technicalPrice') ? 'is-invalid' : '' }}"
                                                placeholder="Nhập vào" id="technicalPrice" name="technicalPrice"
                                                value="{{ $product->technicalPrice }}">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon2">VNĐ</span>
                                            </div>
                                            @if ($errors->product->first('technicalPrice'))
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon2">VNĐ</span>
                                                </div>
                                                <div class="invalid-feedback">
                                                    {{ $errors->product->first('technicalPrice') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="brandId">Thương hiệu<span
                                                class="text-danger">&nbsp;*</span></label>
                                        <select
                                            class="form-control
                                {{ $errors->product->first('brandId') ? 'is-invalid' : '' }}"
                                            id="brandId" name="brandId" required>
                                            <option selected disabled value="">---Chọn thương hiệu---</option>
                                            @if (isset($brands) && $brands)
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ $brand->id == $product->brandId ? 'selected' : '' }}>
                                                        {{ $brand->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->product->first('brandId'))
                                            <div class="invalid-feedback">
                                                {{ $errors->product->first('brandId') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="quantity">Số lượng<span
                                                class="text-danger">&nbsp;*</span></label>
                                        <input type="text" id="quantity"
                                            class="form-control
                                    {{ $errors->product->first('quantity') ? 'is-invalid' : '' }}"
                                            placeholder="Nhập vào" id="quantity" name="quantity"
                                            value="{{ $product->quantity }}">
                                        @if ($errors->product->first('quantity'))
                                            <div class="invalid-feedback">
                                                {{ $errors->product->first('quantity') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="SKU">SKU<span
                                                class="text-danger">&nbsp;*</span></label>
                                        <input type="text" id="firstName"
                                            class="form-control
                                    {{ $errors->product->first('SKU') ? 'is-invalid' : '' }}"
                                            placeholder="Nhập vào" id="SKU" name="SKU" value="{{ $product->SKU }}">
                                        @if ($errors->product->first('SKU'))
                                            <div class="invalid-feedback">
                                                {{ $errors->product->first('SKU') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <?php
                            $images = $product->getMedia('images');
                            ?>
                            <div>
                                <h5 class="card-title m-t-20">Hình ảnh sản phẩm<span class="text-danger">&nbsp;*</span>
                                </h5>
                                <p>Hình ảnh đang hiển thị là hình ảnh có kích thước 200x200</p>

                                <div class="btn btn-info mb-4 browseMediaBtn" data-toggle="modal"
                                    data-target="#mediaLibraryModal">
                                    <span class="ml-2">Chọn hình ảnh</span>
                                </div>
                                <div class="d-flex flex-wrap mb-5" id="imagesPreview">
                                    @foreach ($images as $key => $image)
                                        <div class="preview-image" data-mediaid="{{ $image->id }}">
                                            <img class="img-fluid img-thumbnail" src="{{ $image->getUrl('thumb') }}">
                                            <button class="btn btn-danger btn-circle btn-remove-image" type="button"
                                                onclick="removeImage({{ $image->id }});">
                                                ✕
                                            </button>
                                            <div>
                                                <a class="d-block my-2" href="#" data-toggle="lightbox"
                                                    data-title="Ảnh 600x600"
                                                    data-remote="{{ $image->getUrl('preview') }}"
                                                    data-footer="{{ $image->file_name }}">Xem hình
                                                    ảnh 600x600</a>
                                                <a class="d-block" href="#" data-toggle="lightbox"
                                                    data-title="Ảnh gốc" data-remote="{{ $image->getUrl() }}"
                                                    data-footer="{{ $image->file_name }}">Xem hình
                                                    ảnh gốc</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="listMediaIds">
                            </div>
                            <h5 class="card-title m-t-40">Mô tả<span class="text-danger">&nbsp;*</span></h5>
                            <div class="btn btn-info mb-4 browseMediaBtn" data-toggle="modal"
                                data-target="#mediaLibraryModal" data-isdesc="1">
                                <span class="ml-2">Chọn hình ảnh</span>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div
                                        class="{{ $errors->product->first('desc') ? 'textarea-validate is-invalid' : '' }}">
                                        <textarea id="descTxtArea" name="desc">{{ $product->desc }}</textarea>
                                    </div>
                                    @if ($errors->product->first('desc'))
                                        <div class="textarea-validate invalid-feedback">
                                            {{ $errors->product->first('desc') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title m-t-40">Trạng thái</h5>
                        <input data-width="80" data-on="Hiện" data-off="Ẩn" class="chkToggle" type="checkbox"
                            data-toggle="toggle" data-onstyle="success" name="status"
                            {{ $product->status ? 'checked' : '' }}>

                        <h5 class="card-title m-t-40">Thông tin SEO</h5>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <label class="control-label" for="title">Title<span
                                            class="text-danger">&nbsp;*</span></label>
                                    <textarea
                                        class="form-control {{ $errors->product->first('title') ? 'is-invalid' : '' }}"
                                        name="title" rows="4">{{ $product->title }}</textarea>
                                    @if ($errors->product->first('title'))
                                        <div class="invalid-feedback">
                                            {{ $errors->product->first('title') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <label class="control-label" for="meta_title">Meta title<span
                                            class="text-danger">&nbsp;*</span></label>
                                    <textarea
                                        class="form-control {{ $errors->product->first('meta_title') ? 'is-invalid' : '' }}"
                                        name="meta_title" rows="4">{{ $product->meta_title }}</textarea>
                                    @if ($errors->product->first('meta_title'))
                                        <div class="invalid-feedback">
                                            {{ $errors->product->first('meta_title') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <label class="control-label" for="meta_desc">Meta description<span
                                            class="text-danger">&nbsp;*</span></label>
                                    <textarea
                                        class="form-control {{ $errors->product->first('meta_desc') ? 'is-invalid' : '' }}"
                                        name="meta_desc" rows="4">{{ $product->meta_desc }}</textarea>
                                    @if ($errors->product->first('meta_desc'))
                                        <div class="invalid-feedback">
                                            {{ $errors->product->first('meta_desc') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <label class="control-label" for="meta_keywords">Meta keywords<span
                                            class="text-danger">&nbsp;*</span></label>
                                    <textarea
                                        class="form-control {{ $errors->product->first('meta_keywords') ? 'is-invalid' : '' }}"
                                        name="meta_keywords" rows="4">{{ $product->meta_keywords }}</textarea>
                                    @if ($errors->product->first('meta_keywords'))
                                        <div class="invalid-feedback">
                                            {{ $errors->product->first('meta_keywords') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                </div>
                <div class="form-actions m-t-40">
                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Lưu</button>
                    <button type="button" class="btn btn-dark btn-cancel">Hủy</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Column -->
    </div>

@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"
        integrity="sha512-Y2IiVZeaBwXG1wSV7f13plqlmFOx8MdjuHyYFVoYzhyRr3nH/NMDjTBSswijzADdNzMyWNetbLMfOpIPl6Cv9g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://releases.transloadit.com/uppy/v2.1.0/uppy.min.js"></script>
    <script src="https://releases.transloadit.com/uppy/locales/v2.0.0/vi_VN.min.js"></script>
    <script src="{{ asset('admin/assets/libs/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs\summernote\dist\lang\summernote-vi-VN.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script>
        var isMediaForDesc = false;
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
        $('.chkToggle').bootstrapToggle();
        $("#mediaLibraryModal").on("show.bs.modal", loadMediaContent);
        $("#mediaUploadModal").on("hide.bs.modal", loadMediaContent);

        function loadMediaContent() {
            $("#mediaLibraryModal .modal-body").html('Đang tải...');
            $('#mediaLibraryModal').find(".modal-body").load(mediaListUrl);
        }

        $(".browseMediaBtn").each(function(index) {
            $(this).on("click", function() {
                if (this.dataset.isdesc) {
                    isMediaForDesc = true;
                }
            });
        });

        $("#mediaLibraryModal").on("hide.bs.modal", function(e) {
            $("#mediaLibraryModal .modal-body").html('Đang tải...');
        });
        $("#mediaLibraryChooseBtn").on("click", function(e) {
            var $listMedia = $('.preview-image');
            var listMediaIds = [];
            for (let index = 0; index < $listMedia.length; index++) {
                listMediaIds.push($listMedia[index].dataset.mediaid);
            }
            var $checkedBoxes = $('.custom-control.image-checkbox .custom-control-input:checked');
            var previewMultipleHtml = '';
            for (let index = 0; index < $checkedBoxes.length; index++) {
                var mediaId = $checkedBoxes[index].dataset.mediaid;
                var mediaUrl = $checkedBoxes[index].dataset.url;
                if (isMediaForDesc) {
                    var mediaOgUrl = $checkedBoxes[index].dataset.ogurl;
                    previewMultipleHtml += '<img src="' + mediaOgUrl + '"/>';
                } else {
                    if (listMediaIds.indexOf(mediaId) != -1) {
                        console.warn('Hình ảnh id=' + mediaId + ' đã chọn rồi!');
                        continue;
                    }
                    previewMultipleHtml += `
                        <div class="preview-image" data-mediaid="${mediaId}">
                            <img class="img-fluid img-thumbnail" src="${mediaUrl}">
                            <button class="btn btn-danger btn-circle btn-remove-image" type="button" 
                            onclick="removeImage(${mediaId});">
                            ✕
                            </button>
                            ${$($checkedBoxes[index].parentElement).next().html()}
                        </div>
                        `;
                }
            }
            if (isMediaForDesc) {
                let html = $('#descTxtArea').summernote('code');
                $('#descTxtArea').summernote('code', html + previewMultipleHtml);
            } else {
                $("#imagesPreview").append(previewMultipleHtml);
            }
            $('#mediaLibraryModal').modal('toggle');
        });

        // Remove image
        function removeImage(mediaId) {
            const result = confirm("Xác nhận xóa hình này?");
            if (result == true) {
                $(`.preview-image[data-mediaid="${mediaId}"]`).remove();
            }
        }
        var uppy = new Uppy.Core({
            autoProceed: false,
            locale: Uppy.locales.vi_VN,
            restrictions: {
                maxFileSize: 10000000,
                allowedFileTypes: ['image/*']
            }
        })
        uppy.use(Uppy.Dashboard, {
            target: '#mediaUploadDropArea',
            inline: true,
            width: '100%',
            height: 450
        })
        uppy.on('upload', (data) => {
            const files = uppy.getFiles();
            var formData = new FormData();
            for (var x = 0; x < files.length; x++) {
                formData.append("images[]", files[x].data);
            }
            var url = "{{ route('admin.uploadMediaPost') }}";
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
                        msg,
                        url,
                        success_media,
                        fail_media
                    } = data;
                    if (msg == 'success') {
                        Object.keys(uppy.state.files).forEach((file, key) => {
                            if (success_media && success_media.indexOf(key) != -1) {
                                uppy.setFileState(file, {
                                    progress: {
                                        uploadComplete: true,
                                        uploadStarted: true
                                    }
                                })
                            }
                            if (fail_media && fail_media.indexOf(key) != -1) {
                                uppy.setFileState(file, {
                                    error: 'fail'
                                })
                            }

                        })
                    }
                },
                error: function(data) {
                    console.error(data);
                }
            });
        })
        $('#form').on('submit', function(e) {
            var $listMedia = $('.preview-image');
            var listMediaIds = [];
            for (let index = 0; index < $listMedia.length; index++) {
                listMediaIds.push($listMedia[index].dataset.mediaid);
            }
            if (!listMediaIds.length) {
                alert('Không có hình ảnh!');
                return false;
            }
            if ($('#descTxtArea').summernote('isEmpty')) {
                alert('Mô tả không được để trống!');
                return false;
            }
            $('input[name="listMediaIds"]').val(listMediaIds);
        })
        $('.btn-cancel').on('click', function() {
            const result = confirm("Bạn có muốn hủy?");
            if (result == true) {
                window.location = "{{ route('admin.product') }}";
            }
        });

        $('#descTxtArea').summernote({
            lang: "vi-VN",
            height: 500, // set editor height
            focus: false, // set focus to editable area after initializing summernote
            // callbacks: {
            //     onImageUpload: function(images) {
            //         uploadImages(images);
            //     },
            //     onMediaDelete: function(target) {
            //         if (target[0].dataset.mediaid) {
            //             // deleteImage(target[0].dataset.mediaid);
            //         }
            //     }
            // }
        });

        // function uploadImages(images) {
        //     var data = new FormData();
        //     var url = "{{ route('admin.api.uploadImages') }}";
        //     data.append("isDesc", 1);
        //     data.append("productId", $('input[name="id"]').val());
        //     for (var x = 0; x < images.length; x++) {
        //         data.append("images[]", images[x]);
        //     }
        //     data.append("_token", "{{ csrf_token() }}");
        //     $.ajax({
        //         url: url,
        //         cache: false,
        //         contentType: false,
        //         processData: false,
        //         data: data,
        //         type: "POST",
        //         success: function(data) {
        //             const {
        //                 msg,
        //                 imageList
        //             } = data;
        //             if (msg == 'success') {
        //                 imageList.images.forEach(image => {
        //                     var {
        //                         id,
        //                         path
        //                     } = image;
        //                     if (path != '') {
        //                         var image = document.createElement("img");
        //                         image.classList.add('img-desc-uploaded');
        //                         image.src = path;
        //                         image.dataset.mediaid = id;
        //                         $('#descTxtArea').summernote("insertNode", image);
        //                     }
        //                 });
        //                 alert('Upload image success!');
        //             } else {
        //                 alert('Upload image fail!');
        //             }
        //         },
        //         error: function(data) {
        //             console.error(data);
        //             alert('Upload image fail!');
        //         }
        //     });
        // }

        // function deleteImage(id) {
        //     var data = new FormData();
        //     var url = "";
        //     data.append("productId", $('input[name="id"]').val());
        //     data.append("id", id);
        //     data.append("_token", "{{ csrf_token() }}");
        //     $.ajax({
        //         data: data,
        //         cache: false,
        //         contentType: false,
        //         processData: false,
        //         type: "POST",
        //         url: url,
        //         cache: false,
        //         success: function(res) {
        //             if (res.msg == 'success') {
        //                 $('#descTxtArea').summernote("insertNode", image);
        //                 alert('Delete image success!');
        //             } else {
        //                 alert('Delete image fail!');
        //             }
        //         },
        //         error: function(data) {
        //             console.error(data);
        //             alert('Delete image fail!');
        //         }
        //     });
        // }

        $('#categoryId').on('change', function(e) {
            const catLvl1Id = e.target.value;
            $.ajax({
                url: categoriesLv2APIUrl + '/' + catLvl1Id,
                method: "GET",
                success: function(data) {
                    const categoriesLvl2 = JSON.parse(data);
                    let listOptHtml = '';
                    categoriesLvl2.forEach(category => {
                        listOptHtml +=
                            `<option value="${category["id"]}">${category["name"]}</option>`;
                    });

                    $('#categoryIdLv2').html(
                        `<option disabled selected value>---Chọn danh mục 2---</option>` +
                        listOptHtml);
                }
            });
        });
    </script>
@endsection
