<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\Slider;


class SliderController extends BaseController
{
    public function index() {
        $pageName = "Quản Lý Slider";
        $sliders = $this->sliderService->getSliders();
        return view('admin.pages.slider.index', ['sliders' => $sliders, 'data' => ['pageName' => $pageName]]);
    }

    public function add(Request $request)
    {
        $pageName = "Thêm Slider";
        if ($request->isMethod('POST')) {
            try {
                // Validation
                $validator  = $request->validateWithBag(
                    'slider',
                    [
                        'title' => 'required',
                        'content' => 'required',
                        'status' => 'required',
                        'productId' => 'required',
                    ],
                    [
                        'required' => ':attribute không được để trống.',
                    ],
                    [
                        'title' => 'Tiêu đề',
                        'content' => 'Nội dung',
                        'status' => 'Trạng thái',
                        'productId' => 'ID sản phẩm',
                    ]
                );
                if (!$request->hasFile('meta_image')) {
                    throw new Exception('Phải có hình ảnh');
                }
                // Get all parameters from request except some parameters
                $input = $request->except(
                    '_token',
                    'id',
                    'meta_image',
                );
                $slider = new Slider();
                $slider->title = $request->title;
                $slider->content = $request->content;
                $slider->status = $request->status;
                $slider->productId = $request->productId;
                // Store images
                if ($request->hasFile('meta_image')) {
                    $file = $request->file('meta_image');
                    $saveFolder = '/assets/images/sliders/';
                    $fileName = time() .  $file->getClientOriginalName();
                    $file->move(public_path($saveFolder), $fileName);
                    $filePath = $saveFolder . $fileName;
                    $slider->image = $filePath;
                }
                // Update DB


                if (!$slider->save()) {
                    throw new Exception('Lưu dữ liệu thất bại');
                }
                return redirect()->route('admin.editSliderGet', ['id' => $slider->id])
                    ->with('success', 'Thêm slider ' . $slider->title . ' thành công!');
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('fail', 'Thêm slider thất bại! ' . $e->getMessage())->withInput();
            }
        }
        return view('admin.pages.slider.add', compact('pageName'));
    }
    public function edit(Request $request)
    {
        $pageName = "Chỉnh sửa slider";
        $slider = $this->sliderService->getSliderById($request->id);
        // Not exist in DB
        if (!$slider) {
            throw new Exception('Slider không tồn tại: ' . $request->id);
        }
        if ($request->isMethod('POST')) {
            try {
                // Validation
                $validator  = $request->validateWithBag(
                    'slider',
                    [
                        'title' => 'required',
                        'content' => 'required',
                        'status' => 'required',
                        'productId' => 'required',
                    ],
                    [
                        'required' => ':attribute không được để trống.',
                    ],
                    [
                        'title' => 'Tiêu đề',
                        'content' => 'Nội dung',
                        'status' => 'Trạng thái',
                        'productId' => 'ID sản phẩm',
                    ]
                );
                // Get all parameters from request except some parameters
                $input = $request->except(
                    '_token',
                    'id',
                    'meta_image',
                );
                $slider->title = $request->title;
                $slider->content = $request->content;
                $slider->status = $request->status;
                $slider->productId = $request->productId;
                // Store images
                if ($request->hasFile('meta_image')) {
                    $file = $request->file('meta_image');
                    $saveFolder = '/assets/images/sliders/';
                    $fileName = time() .  $file->getClientOriginalName();
                    $file->move(public_path($saveFolder), $fileName);
                    $filePath = $saveFolder . $fileName;
                    $slider->image = $filePath;
                }
                // Update DB

                if (!$slider->save()) {
                    throw new Exception('Lưu dữ liệu thất bại');
                }
                return redirect()->route('admin.editSliderGet', ['id' => $slider->id])
                    ->with('success', 'Cập nhật slider ' . $slider->name . ' thành công!');
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('fail', 'Cập nhật slider thất bại! ' . $e->getMessage())->withInput();
            }
        }
        return view('admin.pages.slider.edit', compact('slider', 'pageName'));
    }

    public function delete(Request $request)
    {
        try {
            if ($request->isMethod('POST')) {
                $id = $request->id;
                $slider = $this->sliderService->getSliderById($id);
                if (!$slider) {
                    throw new Exception('Slider không tồn tại');
                }
                $respose = $slider->delete();
                if (!$respose) {
                    throw new Exception('Lưu dữ liệu thất bại');
                }
                return redirect()->back()
                    ->with('success', 'Xóa slider ' . $slider->title . ' thành công!');
            } else {
                throw new Exception('Method không phù hợp');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('fail', 'Xóa slider thất bại! ' . $e->getMessage());
        }
    }
}
