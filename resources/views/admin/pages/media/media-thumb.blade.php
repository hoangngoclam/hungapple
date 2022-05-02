<div class="media-container">
    <div class="media-wrapper">
        <div class="custom-control custom-checkbox image-checkbox">
            <input type="checkbox" class="custom-control-input" id="media-{{ $image->id }}"
                data-url="{{ $image->getUrl('thumb') }}" data-mediaid="{{ $image->id }}">
            <label class="custom-control-label" for="media-{{ $image->id }}">
                <img src="{{ $image->getUrl('thumb') }}" alt="#" class="img-fluid"
                    onerror="this.onerror=null;this.src='{{ asset('assets/images/image-not-available.jpg') }}';">
            </label>
        </div>
        <div class="media-conversions">
            <a class="d-block my-2" href="#" data-toggle="lightbox" data-title="Ảnh 600x600"
                data-remote="{{ $image->getUrl('preview') }}" data-footer="{{ $image->file_name }}">Xem hình
                ảnh 600x600</a>
            <a class="d-block" href="#" data-toggle="lightbox" data-title="Ảnh gốc"
                data-remote="{{ $image->getUrl() }}" data-footer="{{ $image->file_name }}">Xem hình
                ảnh gốc</a>
        </div>
    </div>
</div>
