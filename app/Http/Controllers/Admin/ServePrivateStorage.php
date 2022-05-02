<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Optix\Media\Models\Media;
use Illuminate\Support\Facades\Storage;

class ServePrivateStorage extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Spatie\MediaLibrary\MediaCollections\Models\Media $media
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $filePath = DIRECTORY_SEPARATOR.'private'.DIRECTORY_SEPARATOR
        .$request->media.DIRECTORY_SEPARATOR.
        $request->filename;
        if (!Storage::exists($filePath)) {
            abort(404);
        }
        return Storage::response($filePath);
    }
}
