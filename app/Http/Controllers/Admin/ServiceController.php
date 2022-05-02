<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use Illuminate\Http\Request;
use App\Models\Service;
use DB;
use Exception;
use Optix\Media\Models\Media;

class ServiceController extends BaseController
{
    public function index(Request $request)
    {
        $pageName = 'Danh sách dịch vụ';
        if ($request->ajax()) {
            $columns = array(
                0 => 'name',
                1 => 'images',
                2 => 'category',
                3 => 'price',
                4 => 'status',
                5 => 'actions'
            );

            $totalData = Service::count();

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            $builder = new Service();
            if (empty($request->input('search.value'))) {
                if (!empty($request->input('catType'))) {
                    $categoryType = $request->input('catType');
                    $categoryId = $request->input('columns.2.search.value');
                    if ($categoryType == 'cat1') {
                        $builder = $builder->where('categoryId', $categoryId);
                    } else if ($categoryType == 'cat2') {
                        $builder = $builder->where('categoryIdLv2', $categoryId);
                    }
                }
            } else {
                $search = $request->input('search.value');
                $builder = $builder->where('name', 'LIKE', "%{$search}%");
            }
            $totalFiltered = $builder
                ->count();

            $services = $builder->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $data = array();
            if (!empty($services)) {
                foreach ($services as $service) {
                    $editRoute =  route('admin.editServiceGet', $service->id);
                    $imagesHtml = '<div class="image-thumb-group">';
                    $images = $service->getMedia('images');
                    foreach ($images as $image) {
                        $imagesHtml .= '<div class="image-thumb-wrapper">
                        <img class="image-thumb small" src="' . $image->getUrl('thumb') . '" width="80px" />
                        <img class="image-thumb big" src="' . $image->getUrl() . '" width="200px" height="200px"/>
                        </div>';
                    }
                    $imagesHtml .= '</div>';
                    $nestedData['id'] = $service->id;
                    $nestedData['name'] = $service->name;
                    $nestedData['images'] = $imagesHtml;
                    $nestedData['category'] = $service->getCategoryLv1Name() . '&nbsp;&nbsp;❯&nbsp;&nbsp;' . $service->getCategoryLv2Name();
                    $nestedData['price'] = number_format($service->price, 0, '', '.') . '&nbsp;VND';
                    $nestedData['status'] = $service->status == 1 ?
                        '<span><input data-on="Hiện" data-off="Ẩn" data-id="' . $service->id . '" class="chkToggle" type="checkbox" data-toggle="toggle" data-onstyle="success" checked></span>'
                        : '<span><input data-on="Hiện" data-off="Ẩn" data-id="' . $service->id . '" class="chkToggle" type="checkbox" data-toggle="toggle" data-onstyle="success"></span>';
                    $nestedData['action'] = '<a href="' . $editRoute . '" class="btn btn-primary mr-2" title="Chỉnh sửa">Chỉnh sửa</a>
                    <button onclick="deleteService(event)" data-id="' . $service->id.'"class="btn btn-danger btn-delete" title="Xóa">Xóa</button>';
                    $data[] = $nestedData;
                }
            }

            $json_data = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data
            );
            return response($json_data, 200);
        }

        // Category
        $allCategories = $this->serviceCategoryService->getCategories();
        $allCategoriesProcessed = [];
        $categoriesLevel2 = [];
        foreach ($allCategories as $key => $category) {
            if ($category->parentId == null) {
                array_push($allCategoriesProcessed, ['id' => $category->id, 'name' => $category->name]);
            } else {

                array_push($categoriesLevel2, ['parentId' => $category->parentId, 'id' => $category->id, 'name' => $category->name]);
            }
        }

        foreach ($categoriesLevel2 as $key => $categoryLevel2) {
            $key = array_search($categoryLevel2['parentId'], array_column($allCategoriesProcessed, 'id'));
            $allCategoriesProcessed[$key]['categoriesLv2'][] = $categoryLevel2;
        }
        return view('admin.pages.service.index', compact('allCategoriesProcessed','pageName'));
    }

    public function add(Request $request)
    {
        $pageName = 'Thêm dịch vụ';
        if ($request->isMethod('POST')) {
            // Validation
            $validator  = $request->validateWithBag(
                'service',
                [
                    'name' => 'required',
                    'categoryId' => 'required|integer',
                    'categoryIdLv2' => 'required|integer',
                    'price' => 'required|numeric|min:0|not_in:0',
                    'promotionPrice' => 'required|numeric|lt:price|min:0|not_in:0',
                    'technicalPrice' => 'numeric|lt:price|min:0|not_in:0|nullable',
                    'brandId' => 'required|integer',
                    'listMediaIds' => 'required|string',
                    'desc' => 'required|string',
                    'title' => 'required',
                    'meta_desc' => 'required',
                    'meta_keywords' => 'required',
                    'meta_title' => 'required'
                ],
                [
                    'required' => ':attribute không được để trống.',
                ],
                [
                    'name' => 'Tên dịch vụ',
                    'categoryId' => 'Danh mục 1',
                    'categoryIdLv2' => 'Danh mục 2',
                    'price' => 'Giá',
                    'promotionPrice' => 'Giảm giá',
                    'technicalPrice' => 'Giá kĩ thuật',
                    'brandId' => 'Thương hiệu',
                    'listMediaIds' => 'Hình ảnh',
                    'desc' => 'Mô tả',
                    'title' => 'Title',
                    'meta_desc' => 'Meta description',
                    'meta_keywords' => 'Meta keywords',
                    'meta_title' => 'Meta title'
                ]
            );
            try {
                if ($request->filled('listMediaIds')) {
                    $mediaListIds = explode(",", $request->listMediaIds);
                } else {
                    throw new Exception('Không có hình ảnh');
                }
                // Get all parameters from request except some parameters
                $input = $request->except(
                    '_token',
                    'id',
                    'sold',
                );
                $service = new Service();
                $service->fill($input);

                DB::beginTransaction();
                try {
                    $service->save();
                    foreach ($mediaListIds as $mediaId) {
                        $media = Media::find($mediaId);
                        if (!$media) {
                            throw new Exception('Không tồn tại hình ảnh');
                        }
                        $service->attachMedia($media, 'images');
                    }
                    $service->save();
                    DB::commit();
                    return redirect()->route('admin.editServiceGet', ['id' => $service->id])
                        ->with('success', 'Thêm dịch vụ ' . $service->name . ' thành công!');
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw new Exception('Lưu dữ liệu thất bại');
                }
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('fail', 'Thêm dịch vụ thất bại! ' . $e->getMessage())->withInput();
            }
        }
        $lvl1Categories = $this->serviceCategoryService->getAllCategoriesLevel1();
        $brands = $this->brandService->getBrands();
        return view('admin.pages.service.add', compact('lvl1Categories', 'brands','pageName'));
    }

    public function edit(Request $request)
    {
        $pageName = 'Chỉnh sửa dịch vụ';
        $service = $this->repairServiceService->serviceDetail($request->id);
        if ($request->isMethod('POST')) {
            // Validation
            $validator  = $request->validateWithBag(
                'service',
                [
                    'name' => 'required',
                    'categoryId' => 'required|integer',
                    'categoryIdLv2' => 'required|integer',
                    'price' => 'required|numeric|min:0|not_in:0',
                    'promotionPrice' => 'required|numeric|lt:price|min:0|not_in:0',
                    'technicalPrice' => 'numeric|lt:price|min:0|not_in:0|nullable',
                    'brandId' => 'required|integer',
                    'listMediaIds' => 'required|string',
                    'desc' => 'required|string',
                    'title' => 'required',
                    'meta_desc' => 'required',
                    'meta_keywords' => 'required',
                    'meta_title' => 'required'
                ],
                [
                    'required' => ':attribute không được để trống.',
                ],
                [
                    'name' => 'Tên dịch vụ',
                    'categoryId' => 'Danh mục 1',
                    'categoryIdLv2' => 'Danh mục 2',
                    'price' => 'Giá',
                    'promotionPrice' => 'Giảm giá',
                    'technicalPrice' => 'Giá kĩ thuật',
                    'brandId' => 'Thương hiệu',
                    'listMediaIds' => 'Hình ảnh',
                    'desc' => 'Mô tả',
                    'title' => 'Title',
                    'meta_desc' => 'Meta description',
                    'meta_keywords' => 'Meta keywords',
                    'meta_title' => 'Meta title'
                ]
            );
            try {
                // Not exist service in DB
                if (!$service) {
                    throw new Exception('Service not exist. Service id: ' . $request->id);
                }
                if ($request->filled('listMediaIds')) {
                    $mediaListIds = explode(",", $request->listMediaIds);
                    $currMediaList = $service->getMedia('images')->pluck('id')->toArray();
                    $attachMediaIds = array_diff($mediaListIds, $currMediaList);
                    $detachMediaIds = array_diff($currMediaList, $mediaListIds);
                }
                // Get all parameters from request except some parameters
                $input = $request->except(
                    '_token',
                    'id',
                    'sold',
                );

                $service->fill($input);

                DB::beginTransaction();
                try {
                    foreach ($attachMediaIds as $mediaId) {
                        $media = Media::find($mediaId);
                        if (!$media) {
                            throw new Exception('Không tồn tại hình ảnh');
                        }
                        $service->attachMedia($media, 'images');
                    }
                    foreach ($detachMediaIds as $mediaId) {
                        $media = Media::find($mediaId);
                        if (!$media) {
                            throw new Exception('Không tồn tại hình ảnh');
                        }
                        $service->detachMedia($media, 'images');
                    }

                    $service->save();

                    DB::commit();
                    return redirect()->back()
                        ->with('success', 'Sửa dịch vụ ' . $service->name . ' thành công!');
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw new Exception('Lưu dữ liệu thất bại');
                }
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('fail', 'Sửa dịch vụ thất bại!' . $e->getMessage())->withInput();
            }
        }
        $lvl1Categories = $this->serviceCategoryService->getAllCategoriesLevel1();
        $brands = $this->brandService->getBrands();
        return view('admin.pages.service.edit', compact('service', 'lvl1Categories', 'brands','pageName'));
    }

    public function delete(Request $request)
    {
        try {
            if ($request->ajax() && $request->isMethod('POST')) {
                $validated = $request->validate([
                    'id' => 'required|integer'
                ]);
                $productId = $this->repairServiceService->deleteService($request->id);
                $response['msg'] = 'success';
                $response['id'] = $productId;
                return response()->json($response, 200);
            } else {
                throw new Exception('Request không phải ajax POST');
            }
        } catch (\Exception $ex) {
            $response['msg'] = 'fail';
            return response()->json($response, 400);
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            if ($request->ajax() && $request->isMethod('POST')) {
                $validated = $request->validate([
                    'id' => 'required|integer',
                    'status' => 'required|integer|in:1,0',
                ]);
                $service = $this->repairServiceService->serviceDetail($request->id);
                // Not exist service in DB
                if (!$service) {
                    throw new Exception('dịch vụ không tồn tại. Id: ' . $request->id);
                }
                $service->status = $request->status;
                if (!$service->save()) {
                    throw new Exception('Lưu dữ liệu thất bại');
                }
                $response['msg'] = 'success';
                return response()->json($response, 200);
            } else {
                throw new Exception('Request không phải ajax POST');
            }
        } catch (\Exception $ex) {
            $response['msg'] = 'fail';
            return response()->json($response, 401);
        }
    }
}
