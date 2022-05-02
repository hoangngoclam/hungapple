<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Exception;
use App\Models\Category;
use App\Services\BrandService;

class BrandController extends BaseController
{
    public function index() {
        $pageName = "Quản Lý Thương Hiệu";
        $brands = $this->brandService->getBrands();
        return view('admin.pages.brand.index', ['brands' => $brands, 'data' => ['pageName' => $pageName]]);
    }

    public function add(Request $request)
    {

        $pageName = "Thêm thương hiệu";
        if ($request->isMethod('POST')) {
            try {
                // Validation
                $validator  = $request->validateWithBag(
                    'brand',
                    [
                        'name' => 'required',
                    ],
                    [
                        'required' => ':attribute không được để trống.',
                    ],
                    [
                        'name' => 'Tên thương hiệu',
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
                $brand = new Brand();
                $brand->name = $request->name;
                // Store images
                if ($request->hasFile('meta_image')) {
                    $file = $request->file('meta_image');
                    $saveFolder = '/assets/images/brands/';
                    $fileName = time() .  $file->getClientOriginalName();
                    $file->move(public_path($saveFolder), $fileName);
                    $filePath = $saveFolder . $fileName;
                    $brand->image = $filePath;
                }
                // Update DB


                if (!$brand->save()) {
                    throw new Exception('Lưu dữ liệu thất bại');
                }
                return redirect()->route('admin.editBrandGet', ['id' => $brand->id])
                    ->with('success', 'Thêm thương hiệu ' . $brand->name . ' thành công!');
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('fail', 'Thêm thương hiệu thất bại! ' . $e->getMessage())->withInput();
            }
        }
        return view('admin.pages.brand.add', compact('pageName'));
    }

    public function edit(Request $request)
    {
        $pageName = "Chỉnh sửa thương hiệu";
        $brand = $this->brandService->getBrandById($request->id);
        // Not exist in DB
        if (!$brand) {
            throw new Exception('Thương hiệu không tồn tại: ' . $request->id);
        }
        if ($request->isMethod('POST')) {
            try {
                // Validation
                $validator  = $request->validateWithBag(
                    'slider',
                    [
                        'name' => 'required',
                    ],
                    [
                        'required' => ':attribute không được để trống.',
                    ],
                    [
                        'name' => 'Tên thương hiệu',
                    ]
                );
                // Get all parameters from request except some parameters
                $input = $request->except(
                    '_token',
                    'id',
                    'meta_image',
                );
                $brand->name = $request->name;

                // Store images
                if ($request->hasFile('meta_image')) {
                    $file = $request->file('meta_image');
                    $saveFolder = '/assets/images/brands/';
                    $fileName = time() .  $file->getClientOriginalName();
                    $file->move(public_path($saveFolder), $fileName);
                    $filePath = $saveFolder . $fileName;
                    $brand->image = $filePath;
                }
                // Update DB

                if (!$brand->save()) {
                    throw new Exception('Lưu dữ liệu thất bại');
                }
                return redirect()->route('admin.editBrandGet', ['id' => $brand->id])
                    ->with('success', 'Cập nhật thương hiệu ' . $brand->name . ' thành công!');
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('fail', 'Cập nhật thương hiệu thất bại! ' . $e->getMessage())->withInput();
            }
        }
        return view('admin.pages.brand.edit', compact('brand', 'pageName'));
    }

    public function delete(Request $request)
    {
        try {
            if ($request->isMethod('POST')) {
                $id = $request->id;
                $brand = $this->brandService->getBrandById($id);
                if (!$brand) {
                    throw new Exception('Thương hiệu không tồn tại');
                }
                $respose = $brand->delete();
                if (!$respose) {
                    throw new Exception('Lưu dữ liệu thất bại');
                }
                return redirect()->back()
                    ->with('success', 'Xóa thương hiệu ' . $brand->name . ' thành công!');
            } else {
                throw new Exception('Method không phù hợp');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('fail', 'Xóa thương hiệu thất bại! ' . $e->getMessage());
        }
    }
}
