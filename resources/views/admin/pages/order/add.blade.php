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
    @if ($errors->order->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->order->all() as $error)
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
                    <form id="form" action="{{ route('admin.addOrderPost') }}" method="POST"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-body">
                            <h5 class="card-title">Th??ng tin ????n h??ng</h5>
                            <div><strong>Ch?? ??:&nbsp;</strong>M???c<span class="text-danger">&nbsp;*&nbsp;</span>l?? b???t bu???c
                                ph???i nh???p/ch???n</div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="nameUser">H??? t??n<span
                                                class="text-danger">&nbsp;*</span></label>
                                        <input type="text" id="nameUser"
                                            class="form-control
                                    {{ $errors->order->first('nameUser') ? 'is-invalid' : '' }}"
                                            placeholder="Nh???p v??o" name="nameUser"
                                            value="" required>
                                        @if ($errors->order->first('nameUser'))
                                            <div class="invalid-feedback">
                                                {{ $errors->order->first('nameUser') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="phoneNumber">S??? ??i???n tho???i<span
                                                class="text-danger">&nbsp;*</span></label>
                                        <input type="text" id="phoneNumber"
                                            class="form-control
                                    {{ $errors->order->first('phoneNumber') ? 'is-invalid' : '' }}"
                                            placeholder="Nh???p v??o" name="phoneNumber"
                                            value="" required>
                                        @if ($errors->order->first('phoneNumber'))
                                            <div class="invalid-feedback">
                                                {{ $errors->order->first('phoneNumber') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="address">?????a ch???<span
                                                class="text-danger">&nbsp;*</span></label>
                                        <input type="text" id="address"
                                            class="form-control
                                    {{ $errors->order->first('address') ? 'is-invalid' : '' }}"
                                            placeholder="Nh???p v??o" name="address"
                                            value="" required>
                                        @if ($errors->order->first('address'))
                                            <div class="invalid-feedback">
                                                {{ $errors->order->first('address') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="infoAdd">Ghi ch??<span
                                                class="text-danger">&nbsp;*</span></label>
                                        <input type="text" id="infoAdd"
                                            class="form-control
                                    {{ $errors->order->first('infoAdd') ? 'is-invalid' : '' }}"
                                            placeholder="Nh???p v??o" name="infoAdd"
                                            value="" required>
                                        @if ($errors->order->first('infoAdd'))
                                            <div class="invalid-feedback">
                                                {{ $errors->order->first('infoAdd') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="payment_method">Ph????ng th???c thanh to??n<span
                                                class="text-danger">&nbsp;*</span></label>

                                        <select class="form-control
                                        {{ $errors->order->first('payment_method') ? 'is-invalid' : '' }}" id="payment_method" name="payment_method" required>

                                            <option value="1">Tr??? sau</option>
                                            <option value="0">Chuy???n kho???n</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="status">Tr???ng th??i ????n h??ng<span
                                                class="text-danger">&nbsp;*</span></label>

                                        <select class="form-control
                                        {{ $errors->order->first('status') ? 'is-invalid' : '' }}" id="status" name="status" required>

                                            <option value="1">Nh???n ????n</option>
                                            <option value="0">H???y ????n</option>
                                            <option value="2">Ch???t ????n</option>
                                        </select>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions m-t-40">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> L??u</button>
                            <button type="button" class="btn btn-dark btn-cancel">Quay l???i danh s??ch ????n h??ng</button>
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
            window.location = "{{ route('admin.order') }}";
        });

        $('#descTxtArea').summernote({
            lang: "vi-VN",
            height: 700, // set editor height
            focus: false, // set focus to editable area after initializing summernote
        });
    </script>
@endsection
