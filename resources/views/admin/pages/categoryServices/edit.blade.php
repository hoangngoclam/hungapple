@extends('admin.master')
@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('admin/assets/libs/summernote/dist/summernote-bs4.css')}}">
<link href="{{asset('admin/assets/libs/magnific-popup/dist/magnific-popup.css')}}" rel="stylesheet">
<link href="https://releases.transloadit.com/uppy/v2.1.0/uppy.min.css" rel="stylesheet">
<style>
    .btn-remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
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
</style>
@endsection
@section('content')
@if (Session::has('success'))
<div class="alert alert-success">{{ Session::get('success') }}
    @if (Session::has('productId'))
    <a href="{{route('product.detail',['id'=>Session::get('productId')])}}" target="_blank">
        Xem sản phẩm trên trang
    </a>
    @endif
</div>
@endif
@if (Session::has('fail'))
<div class="alert alert-danger">{{ Session::get('fail') }}</div>
@endif
@if($errors->product->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->product->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="row">
    <!-- Column -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.editServiceCategoryPost')}}" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" value="{{$category->id}}" name="id">
                    <div class="form-body">
                        <h5 class="card-title">Thông tin danh mục</h5>
                        <div><strong>Chú ý:&nbsp;</strong>Mục<span class="text-danger">&nbsp;*&nbsp;</span>là bắt buộc phải nhập/chọn</div>
                        <hr>
                        <!--/row-->
                        <!--/row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="parentId">Danh mục 1<span class="text-danger">&nbsp;*</span></label>
                                    <select class="form-control" id="parentId" name="parentId">
                                        
                                        @if ($lvl1Categories)
                                            @if ($category->parentId == null)
                                                <option selected value="null">---Là danh mục cha---</option>
                                            @else
                                                <option value="null">---Là danh mục cha---</option>
                                            @endif

                                            @foreach ($lvl1Categories as $categoryL1)
                                                @if($category->parentId == $categoryL1->id)
                                                    <option selected value="{{ $categoryL1->id }}"}}>
                                                        {{ $categoryL1->name }}
                                                    </option>
                                                @else
                                                    
                                                    <option value="{{ $categoryL1->id }}"}}>
                                                        {{ $categoryL1->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Tên danh mục<span class="text-danger">&nbsp;*</span></label>
                                    <input type="text" id="name" class="form-control 
                                    {{$errors->category->first('name') ? 'is-invalid' : ''}}" placeholder="Nhập vào" name="name"
                                    value="{{$category->name}}">
                                    @if($errors->category->first('name'))
                                    <div class="invalid-feedback">
                                        {{$errors->category->first('name')}}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <!--/span-->
                        </div>
                    </div>


                    <h5 class="card-title m-t-40">Thông tin SEO</h5>
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="form-group">
                                <label class="control-label" for="meta_title">Meta title<span class="text-danger">&nbsp;*</span></label>
                                <textarea class="form-control {{$errors->category->first('meta_title') ? 'is-invalid' : ''}}" name="meta_title" rows="4">{{ $category->meta_title }}</textarea>
                                @if($errors->category->first('meta_title'))
                                <div class="invalid-feedback">
                                    {{$errors->category->first('meta_title')}}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="form-group">
                                <label class="control-label" for="meta_desc">Meta description<span class="text-danger">&nbsp;*</span></label>
                                <textarea class="form-control {{$errors->category->first('meta_desc') ? 'is-invalid' : ''}}" name="meta_desc" rows="4">{{ $category->meta_desc }}</textarea>
                                @if($errors->category->first('meta_desc'))
                                <div class="invalid-feedback">
                                    {{$errors->category->first('meta_desc')}}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="form-group">
                                <label class="control-label" for="meta_keywords">Meta keywords<span class="text-danger">&nbsp;*</span></label>
                                <textarea class="form-control {{$errors->category->first('meta_keywords') ? 'is-invalid' : ''}}" name="meta_keywords" rows="4">{{ $category->meta_keywords }}</textarea>
                                @if($errors->category->first('meta_keywords'))
                                <div class="invalid-feedback">
                                    {{$errors->category->first('meta_keywords')}}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
            </div>
            <div class="form-actions m-t-40">
                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Lưu</button>
                <a type="button" class="btn btn-dark btn-cancel" href="{{route('admin.serviceCategory')}}">Hủy</a>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Column -->
</div>

@endsection
@section('script')
<script src="https://releases.transloadit.com/uppy/v2.1.0/uppy.min.js"></script>
<script src="{{asset('admin/assets/libs/summernote/dist/summernote-bs4.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js')}}"></script>
<script>
    const uppy = new Uppy.Core({
        autoProceed: false
    })
    uppy.use(Uppy.Dashboard, {
        target: '#drag-drop-area',
        inline: true,
        height: 450
    })
    uppy.on('files-added', (files) => {

    })
    uppy.on('upload', (data) => {
        const files = uppy.getFiles();
        var formData = new FormData();
        for (var x = 0; x < files.length; x++) {
            formData.append("images[]", files[x].data);
        }
        var url = "{{ route('admin.api.uploadImages') }}";
        formData.append("productId", $('input[name="id"]').val());
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
                    url
                } = JSON.parse(data);
                if (msg == 'success') {
                    var image = $('<img>').attr('src', url);
                    $('#descTxtArea').summernote("insertNode", image[0]);
                }
            },
            error: function(data) {
                alert(data)
            }
        });
    })

    $('#specialOffer').on('change', function() {
        if ($(this).is(':checked')) {
            $('#end_offer_date_wrapper').css("display", "block");
        } else {
            $('#end_offer_date_wrapper').css("display", "none");
        }
    });
    $('.btn-add-attribute').on('click', function() {
        var attributeHtml = `<tr>
                                <td>
                                    <input type="text" class="form-control" placeholder="Tên thuộc tính" name="attribute_names[]" value="">
                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="Giá trị thuộc tính" name="attribute_values[]" value="">
                                </td>
                            </tr>`;
        $('#attributes').append(attributeHtml);
    });
    $('.btn-cancel').on('click', function() {
        const result = confirm("Bạn có muốn hủy?");
        if (result == true) {
            window.location = "{{ route('admin.product') }}";
        }
    });
    $('.image-popup-vertical-fit').magnificPopup({
        type: 'image',
        closeOnContentClick: true
    });
    $('#descTxtArea').summernote({
        height: 500, // set editor height
        focus: false, // set focus to editable area after initializing summernote
        callbacks: {
            onImageUpload: function(image) {
                uploadImage(image[0]);
            },
            onMediaDelete: function(target) {
                alert(target[0].src)
                deleteFile(target[0].src);
            }
        }
    });

    function uploadImage(image) {
        console.log(image);
        var data = new FormData();
        var url = "{{ route('admin.api.uploadImages') }}";
        data.append("productId", $('input[name="id"]').val());
        data.append("image", image);
        data.append("_token", "{{ csrf_token() }}");
        $.ajax({
            url: url,
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: "POST",
            success: function(data) {
                const {
                    msg,
                    url
                } = JSON.parse(data);
                if (msg == 'success') {
                    var image = $('<img>').attr('src', url);
                    $('#descTxtArea').summernote("insertNode", image[0]);
                }
            },
            error: function(data) {
                alert(data)
            }
        });
    }

    function deleteFile(src) {
        var data = new FormData();
        var url = "{{ route('admin.api.deleteImage') }}";
        data.append("productId", $('input[name="id"]').val());
        data.append("imagePath", src);
        data.append("_token", "{{ csrf_token() }}");
        $.ajax({
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: "POST",
            url: base_url + "dropzone/delete_file", // replace with your url
            cache: false,
            success: function(resp) {
                console.log(resp);
            }
        });
    }

    // Remove image
    function removeImage(e) {
        const removeTarget = e.target.dataset.target;
        const result = confirm("Xác nhận xóa hình này?");
        if (result == true) {
            if (removeTarget.indexOf("subImage") >= 0) {
                $(`.preview-image[data-img-type="${removeTarget}"]`).remove();
                let subImagesDel = $('input[name="subImages_del"]').val();
                const currentSubImagePos = e.target.dataset.position;
                if ($('input[name="subImages_del"]').val() !== '') {
                    subImagesDel += ',' + currentSubImagePos;
                } else {
                    subImagesDel += currentSubImagePos;
                }
                $('input[name="subImages_del"]').val(subImagesDel);
            } else {
                const noImageHtml = `<div class="el-card-item">
                                        <div class="el-card-avatar el-overlay-1">
                                            <img src="{{asset('admin/assets/images/placeholder_540_600.jpg')}}" alt="">
                                        </div>
                                    </div>`;
                $(`.preview-image[data-img-type="${removeTarget}"]`).html(noImageHtml);
                $(`input[name="${removeTarget+'Url'}"]`).val('');
            }
        }
    }
    // Trigger change input
    $('.upload-input').each(function(index, item) {
        $(item).on('click', function(e) {
            $(`input[name='${$(this).data('img-type')}']`).click();
        });
    });
    // Trigger event for checkbox
    $('input.product-type-input[type="checkbox"]').each(function(index, item) {
        $(item).on('change', function(e) {
            if ($(item).is(':checked')) {
                $(item).val("1");
            } else {
                $(item).val("0");
            }
        });
    });



    $('input[type="file"]').each(function(index, item) {
        $(item).on('change', function(e) {
            const currentTarget = e.target;
            var files = e.target.files;

            const subImagesPreviewEle = document.querySelector('#subImagesPreview');
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var imageType = /image.*/;
                if (!file.type.match(imageType)) {
                    continue;
                }
                var img = document.querySelector(`img[data-img-type="${e.target.name}"]`);
                var imgLink = document.querySelector(`a[data-img-type="${e.target.name}"]`);
                var reader = new FileReader();
                var position = 1;
                reader.onload = function(e) {
                    $(`.preview-image[data-img-type="${currentTarget.name}"]`).html('');
                    if (currentTarget.name == 'subImages[]') {
                        const previewMultipleHtml = `<div class="col-md-3 preview-image" data-img-type="subImage_new_${position}">
                                    <div class="el-element-overlay">
                                        <div class="el-card-item">
                                            <div class="el-card-avatar el-overlay-1"> <img src="${e.target.result}" alt="user" data-img-type="subImage">
                                            <div class="el-overlay">
                                                <ul class="list-style-none el-info">
                                                <li class="el-item"><a class="btn default btn-outline image-popup-vertical-fit el-link" href="${e.target.result}"><i class="icon-magnifier"></i></a></li>
                                                </ul>
                                            </div>
                                                <button class="btn btn-danger btn-circle btn-remove-image" type="button" data-target="subImage_new_${position}" onclick="removeImage(event);">
                                                <i class="icon-trash" style="pointer-events: none;"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                        $("#subImagesPreview").append(previewMultipleHtml);
                        position += 1;
                    } else {
                        const previewHtml = `<div class="el-card-item">
                                        <div class="el-card-avatar el-overlay-1"><img src="${e.target.result}" alt="" data-img-type="${currentTarget.name}">
                                            <div class="el-overlay">
                                                <ul class="list-style-none el-info">
                                                <li class="el-item"><a class="btn default btn-outline image-popup-vertical-fit el-link" href="${e.target.result}"><i class="icon-magnifier"></i></a></li>
                                                </ul>
                                            </div>
                                            <button class="btn btn-danger btn-circle btn-remove-image" type="button" data-target="${currentTarget.name}" onclick="removeImage(event);">
                                                <i class="icon-trash" style="pointer-events: none;"></i>
                                            </button>
                                        </div>                                        
                                    </div>`;
                        $(`.preview-image[data-img-type="${currentTarget.name}"]`).html(previewHtml);
                        $(`input[name="${currentTarget.name+'Url'}"]`).val(currentTarget.name);
                    }
                }
                reader.readAsDataURL(file);
            }

        });
    });



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