<?php

namespace App\Http\Controllers\Admin;

use Optix\Media\MediaUploader;
use Illuminate\Http\Request;
use Optix\Media\Jobs\PerformConversions;

class MediaController extends BaseController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $images = $this->mediaService->getListMediaUpload();
            $page = $request->page ? $request->page + 1 : 2;
            $imagesHtml = view('admin.pages.media.index', compact('images', 'page'))->render();
            return $imagesHtml;
        }
        // return view('admin.pages.media.index', compact('images'));
    }

    public function add()
    {
    }

    public function upload(Request $request)
    {
        if ($request->isMethod('POST')) {
            try {
                $response = [];
                $listMediaSuccess = [];
                $listMediaFail = [];
                if ($request->hasFile('images')) {
                    $files = $request->file('images');
                    foreach ($files as $key => $file) {
                        $media = MediaUploader::fromFile($file)->upload();
                        if (!$media) {
                            array_push($listMediaFail, $key);
                            continue;
                        }
                        $conversions = ['thumb', 'preview'];
                        PerformConversions::dispatch(
                            $media,
                            $conversions
                        );
                        array_push($listMediaSuccess, $key);
                    }
                }
                if ($listMediaSuccess) {
                    $response['success_media'] = $listMediaSuccess;
                }
                if ($listMediaFail) {
                    $response['fail_media'] = $listMediaFail;
                }
                $response['msg'] = 'success';
                return response()->json($response, 200);
            } catch (\Exception $ex) {
                dd($ex);
                $response['msg'] = 'fail';
                return response()->json($response, 500);
            }
        }
    }
}
