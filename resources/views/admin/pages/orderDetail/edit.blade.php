@extends('admin.master')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/libs/summernote/dist/summernote-bs4.css') }}">
    {{-- <link href="https://releases.transloadit.com/uppy/v2.1.0/uppy.min.css" rel="stylesheet"> --}}
    <style>
        /* .note-group-select-from-files {
                                                                                                display: none;
                                                                                            } */

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
            width: 500px;
            height: 500px;
            position: relative;
            margin-left: 15px;
            margin-right: 15px;
            margin-bottom: 30px;
        }

        .preview-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-image button {
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
        </div>
    @endif
    @if (Session::has('fail'))
        <div class="alert alert-danger">{{ Session::get('fail') }}</div>
    @endif
    @if ($errors->orderDetail->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->orderDetail->all() as $error)
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
                    <form id="form" action="{{ route('admin.editOrderDetailPost') }}" method="POST"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-body">
                            <h5 class="card-title">Th??ng tin chi ti???t ????n  h??ng</h5>
                            <div><strong>Ch?? ??:&nbsp;</strong>M???c<span class="text-danger">&nbsp;*&nbsp;</span>l?? b???t bu???c
                                ph???i nh???p/ch???n</div>
                            <hr>
                            <input type="hidden" name="id" value="{{$orderDetail->id}}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="productId">ID s???n ph???m<span
                                                class="text-danger">&nbsp;*</span></label>
                                        <input type="text" id="productId"
                                            class="form-control {{ $errors->orderDetail->first('productId') ? 'is-invalid' : '' }}"
                                            placeholder="Nh???p v??o" name="productId" required value="{{$orderDetail->productId}}">
                                        @if ($errors->orderDetail->first('productId'))
                                            <div class="invalid-feedback">
                                                {{ $errors->orderDetail->first('productId') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="quantity">S??? l?????ng<span
                                                class="text-danger">&nbsp;*</span></label>
                                        <input type="text" id="quantity"
                                            class="form-control {{ $errors->orderDetail->first('quantity') ? 'is-invalid' : '' }}"
                                            placeholder="Nh???p v??o" name="quantity" required value="{{$orderDetail->quantity}}">
                                        @if ($errors->orderDetail->first('quantity'))
                                            <div class="invalid-feedback">
                                                {{ $errors->orderDetail->first('quantity') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions m-t-40">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> L??u</button>
                            <button type="button" class="btn btn-dark btn-cancel">Danh s??ch ????n h??ng #id = {{$orderDetail->orderId}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
@endsection
@section('script')
    {{-- <script src="https://releases.transloadit.com/uppy/v2.1.0/uppy.min.js"></script>
    <script src="https://releases.transloadit.com/uppy/locales/v2.0.0/vi_VN.min.js"></script> --}}

    <script src="{{ asset('admin/assets/libs/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs\summernote\dist\lang\summernote-vi-VN.min.js') }}"></script>
    <script>
        var imagePreviewPosition = 0;
        // const existingFiles = [];
        // const existingFilesPos = [];
        // var deleteImages = [];
        // Trigger change input
        $('.upload-input').each(function(index, item) {
            $(item).on('click', function(e) {
                $(`input[name='${$(this).data('target')}']`).click();
            });
        });
        $('input[type="file"]').each(function(index, item) {
            $(item).on('change', function(e) {
                var files = e.target.files;
                var file = files[0];
                // const existingFile = findFile(file);
                // if (existingFile) {
                //     console.error('Existing file: ', existingFile)
                //     continue;
                // }

                var imageType = /image.*/;
                if (!file.type.match(imageType)) {
                    alert('Kh??ng ????ng ?????nh d???ng.')
                }
                var reader = new FileReader();
                reader.onload = function(e) {

                    const previewMultipleHtml = `
                        <a href="#" class="preview-image" data-position="${imagePreviewPosition}">
                            <img class="img-fluid img-thumbnail" src="${e.target.result}" alt="${e.target.name}">
                        </a>
                        `;
                    $("#imagesPreview").html(previewMultipleHtml);
                    // existingFilesPos.push(imagePreviewPosition);
                    imagePreviewPosition += 1;

                }
                reader.readAsDataURL(file);
                // existingFiles.push(file);
            });
        });

        // function findFile(file) {
        //     if (existingFiles.length == 0) {
        //         return false;
        //     }
        //     return existingFiles.find(function(existingFile) {
        //         return (
        //             existingFile.name === file.name &&
        //             existingFile.lastModified === file.lastModified &&
        //             existingFile.size === file.size &&
        //             existingFile.type === file.type
        //         )
        //     })
        // }

        $('.btn-cancel').on('click', function() {
            window.location = "{{ route('admin.orderDetail',['id' => $orderDetail->orderId]) }}";
        });

        $('#descTxtArea').summernote({
            lang: "vi-VN",
            height: 700, // set editor height
            focus: false, // set focus to editable area after initializing summernote
        });

    </script>
@endsection
