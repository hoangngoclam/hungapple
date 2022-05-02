<?php

namespace App\Services;

use Optix\Media\Models\Media;

class MediaService
{
    public function getListMediaUpload()
    {
        $itemsPerPage = config('constants.pagination.MEDIA_THUMBS_PER_PAGE');
        return Media::where('disk', 'public')->orderBy('created_at','desc')->paginate($itemsPerPage);
    }
}
