<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use Optix\Media\MediaUploader;
use DB;
use Exception;
use Optix\Media\Models\Media;

class ProductController extends BaseController
{
    public function index(Request $request)
    {
        $pageName = 'Danh sách sản phẩm';
        if ($request->ajax()) {
            $columns = array(
                0 => 'id',
                1 => 'name',
                2 => 'images',
                3 => 'category',
                4 => 'price',
                5 => 'quantity',
                6 => 'status',
                7 => 'updated_at',
                8 => 'actions'
            );

            $totalData = Product::count();

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            $builder = new Product;
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

            $products = $builder->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $data = array();
            if (!empty($products)) {
                foreach ($products as $product) {
                    $editRoute =  route('admin.editProductGet', $product->id);
                    $imagesHtml = '<div class="image-thumb-group">';
                    $images = $product->getMedia('images');
                    foreach ($images as $image) {
                        $imagesHtml .= '<div class="image-thumb-wrapper">
                        <img class="image-thumb small" src="' . $image->getUrl('thumb') . '" width="80px" alt="thumbnail not available"
                        onerror="this.onerror=null;this.src=\''.asset('assets/images/image-not-available-200.jpg').'\';"/>
                        <img class="image-thumb big" src="' . $image->getUrl('preview') . '" width="200px" height="200px" alt="preview image not available"
                        onerror="this.onerror=null;this.src=\''.asset('assets/images/image-not-available.jpg').'\';"/>
                        </div>';
                    }
                    $imagesHtml .= '</div>';
                    $nestedData['id'] = $product->id;
                    $nestedData['name'] = $product->name;
                    $nestedData['images'] = $imagesHtml;
                    $nestedData['category'] = $product->getCategoryLv1Name() . '&nbsp;&nbsp;❯&nbsp;&nbsp;' . $product->getCategoryLv2Name();
                    $nestedData['price'] = number_format($product->price, 0, '', '.') . '&nbsp;VND';
                    $nestedData['quantity'] = $product->quantity;
                    $nestedData['status'] = $product->status == 1 ?
                        '<span><input data-on="Hiện" data-off="Ẩn" data-id="' . $product->id . '" class="chkToggle" type="checkbox" data-toggle="toggle" data-onstyle="success" checked></span>'
                        : '<span><input data-on="Hiện" data-off="Ẩn" data-id="' . $product->id . '" class="chkToggle" type="checkbox" data-toggle="toggle" data-onstyle="success"></span>';
                    $nestedData['updated_at'] = $product->updated_at->format('d-m-Y H:i');
                    $nestedData['action'] = '<a href="' . $editRoute . '" class="btn btn-primary mr-2" title="Chỉnh sửa">Chỉnh sửa</a>
                    <button onclick="deleteProduct(event)" data-id="' . $product->id.'"class="btn btn-danger btn-delete" title="Xóa">Xóa</button>';
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
        $allCategories = $this->categoryService->getCategories();
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
        return view('admin.pages.product.index', compact('allCategoriesProcessed', 'pageName'));
    }

    public function add(Request $request)
    {
        $pageName = 'Thêm sản phẩm';
        if ($request->isMethod('POST')) {
            // Validation
            $validator  = $request->validateWithBag(
                'product',
                [
                    'name' => 'required',
                    'categoryId' => 'required|integer',
                    'categoryIdLv2' => 'required|integer',
                    'SKU' => 'required',
                    'price' => 'required|numeric|min:0|not_in:0',
                    'promotionPrice' => 'required|numeric|lt:price|min:0|not_in:0',
                    'technicalPrice' => 'numeric|lt:price|min:0|not_in:0|nullable',
                    'brandId' => 'required|integer',
                    'quantity' => 'required|integer|min:0',
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
                    'name' => 'Tên sản phẩm',
                    'categoryId' => 'Danh mục 1',
                    'categoryIdLv2' => 'Danh mục 2',
                    'SKU' => 'SKU',
                    'price' => 'Giá',
                    'promotionPrice' => 'Giảm giá',
                    'technicalPrice' => 'Giá kĩ thuật',
                    'brandId' => 'Thương hiệu',
                    'quantity' => 'Số lượng',
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
                $product = new Product;
                $product->fill($input);
                $product->status = $request->has('status') ? 1 : 0;
                DB::beginTransaction();
                try {
                    $product->save();
                    foreach ($mediaListIds as $mediaId) {
                        $media = Media::find($mediaId);
                        if (!$media) {
                            throw new Exception('Không tồn tại hình ảnh');
                        }
                        $product->attachMedia($media, 'images');
                    }
                    $product->save();
                    DB::commit();
                    return redirect()->route('admin.editProductGet', ['id' => $product->id])
                        ->with('success', 'Thêm sản phẩm ' . $product->name . ' thành công!');
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw new Exception('Lưu dữ liệu thất bại');
                }
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('fail', 'Thêm sản phẩm thất bại! ' . $e->getMessage())->withInput();
            }
        }
        $lvl1Categories = $this->categoryService->getAllCategoriesLevel1();
        $brands = $this->brandService->getBrands();
        return view('admin.pages.product.add', compact('lvl1Categories', 'brands', 'pageName'));
    }

    public function edit(Request $request)
    {
        $pageName = 'Chỉnh sửa sản phẩm';
        $product = $this->productService->productDetail($request->id, false);
        if (!$product) {
            abort(404);
        }
        if ($request->isMethod('POST')) {
            // Validation
            $validator  = $request->validateWithBag(
                'product',
                [
                    'name' => 'required',
                    'categoryId' => 'required|integer',
                    'categoryIdLv2' => 'required|integer',
                    'SKU' => 'required',
                    'price' => 'required|numeric|min:0|not_in:0',
                    'promotionPrice' => 'required|numeric|lt:price|min:0|not_in:0',
                    'technicalPrice' => 'numeric|lt:price|min:0|not_in:0|nullable',
                    'brandId' => 'required|integer',
                    'quantity' => 'required|integer|min:0',
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
                    'name' => 'Tên sản phẩm',
                    'categoryId' => 'Danh mục 1',
                    'categoryIdLv2' => 'Danh mục 2',
                    'SKU' => 'SKU',
                    'price' => 'Giá',
                    'promotionPrice' => 'Giảm giá',
                    'technicalPrice' => 'Giá kĩ thuật',
                    'brandId' => 'Thương hiệu',
                    'quantity' => 'Số lượng',
                    'listMediaIds' => 'Hình ảnh',
                    'desc' => 'Mô tả',
                    'title' => 'Title',
                    'meta_desc' => 'Meta description',
                    'meta_keywords' => 'Meta keywords',
                    'meta_title' => 'Meta title'
                ]
            );
            try {
                // Not exist product in DB
                if (!$product) {
                    throw new Exception('Product not exist. Product id: ' . $request->id);
                }
                if ($request->filled('listMediaIds')) {
                    $mediaListIds = explode(",", $request->listMediaIds);
                    $currMediaList = $product->getMedia('images')->pluck('id')->toArray();
                    $attachMediaIds = array_diff($mediaListIds, $currMediaList);
                    $detachMediaIds = array_diff($currMediaList, $mediaListIds);
                }
                // Get all parameters from request except some parameters
                $input = $request->except(
                    '_token',
                    'id',
                    'sold',
                );

                $product->fill($input);
                $product->status = $request->has('status') ? 1 : 0;

                DB::beginTransaction();
                try {
                    foreach ($attachMediaIds as $mediaId) {
                        $media = Media::find($mediaId);
                        if (!$media) {
                            throw new Exception('Không tồn tại hình ảnh');
                        }
                        $product->attachMedia($media, 'images');
                    }
                    foreach ($detachMediaIds as $mediaId) {
                        $media = Media::find($mediaId);
                        if (!$media) {
                            throw new Exception('Không tồn tại hình ảnh');
                        }
                        $product->detachMedia($media, 'images');
                    }

                    $product->save();

                    DB::commit();
                    return redirect()->back()
                        ->with('success', 'Sửa sản phẩm ' . $product->name . ' thành công!');
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw new Exception('Lưu dữ liệu thất bại');
                }
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('fail', 'Sửa sản phẩm thất bại!' . $e->getMessage())->withInput();
            }
        }
        $lvl1Categories = $this->categoryService->getAllCategoriesLevel1();
        $brands = $this->brandService->getBrands();
        return view('admin.pages.product.edit', compact('product', 'lvl1Categories', 'brands', 'pageName'));
    }

    public function delete(Request $request)
    {
        try {
            if ($request->ajax() && $request->isMethod('POST')) {
                $validated = $request->validate([
                    'id' => 'required|integer'
                ]);
                $productId = $this->productService->deleteProduct($request->id);
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
                $product = $this->productService->productDetail($request->id, false);
                // Not exist product in DB
                if (!$product) {
                    throw new Exception('Sản phẩm không tồn tại. Id: ' . $request->id);
                }
                $product->status = $request->status;
                if (!$product->save()) {
                    throw new Exception('Lưu dữ liệu thất bại');
                }
                $response['msg'] = 'success';
                return response()->json($response, 200);
            } else {
                throw new Exception('Request không phải ajax POST');
            }
        } catch (\Exception $ex) {
            $response['msg'] = 'fail';
            return response()->json($response, 500);
        }
    }
}
