<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\Category;


class CategoryController extends BaseController
{
    public function index() {
        $pageName = "Quản Lý Danh Mục";
        $categories = $this->categoryService->getCategories();
        foreach ($categories as $key => $category) {
            if ($category->parentId != null) {
                $categories[$key]->nameParentId = $this->categoryService->getCategoryLevel2ByIdLevel1($category->parentId)->name;
            }else {
                $category->nameParentId = '##';
            }
        }
        return view('admin.pages.category.index', ['categories' => $categories, 'data' => ['pageName' => $pageName]]);
    }

    public function add(Request $request)
    {
        
        if ($request->isMethod('POST')) {
            $data = array();
            $data['parentId'] = $request->parentId == 'null'? null : $request->parentId;
            $data['name'] = $request->name;
            $data['meta_title'] = $request->meta_title;
            $data['meta_desc'] = $request->meta_desc;
            $data['meta_keywords'] = $request->meta_keywords;
            $category = $this->categoryService->createCategory($data);
            if ($category) {
                return redirect()->route('admin.editCategoryGet', ['id' => $category->id])
                    ->with('success', 'Thêm danh mục ' . $category->name . ' thành công!');
            }
            return redirect()->back()
                    ->with('fail', 'Thêm danh mục thất bại! ');
        }
        $lvl1Categories = $this->categoryService->getAllCategoriesLevel1();
        return view('admin.pages.category.add', compact('lvl1Categories'));
    }
    public function edit(Request $request)
    {
        
        if ($request->isMethod('POST')) {
            // dd($request);
            $data = array();
            $data['id'] = $request->id;
            $data['parentId'] = $request->parentId == 'null'? null : $request->parentId;
            $data['name'] = $request->name;
            $data['meta_title'] = $request->meta_title;
            $data['meta_desc'] = $request->meta_desc;
            $data['meta_keywords'] = $request->meta_keywords;
            $category = $this->categoryService->updateCategory($data);
            if ($category) {
                return redirect()->route('admin.editCategoryGet', ['id' => $category->id])
                    ->with('success', 'Chỉnh sửa danh mục ' . $category->name . 'id = '. $category->id .' thành công!');
            }
            return redirect()->back()
                    ->with('fail', 'Chỉnh sửa danh mục thất bại! ');
        }
        $id = $request->id;
        $category = $this->categoryService->getCategoryById($id);
        $lvl1Categories = $this->categoryService->getAllCategoriesLevel1();
        return view('admin.pages.category.edit', compact('category','lvl1Categories'));
    }

    public function delete(Request $request)
    {
        try {
            if ($request->isMethod('POST')) {
                $id = $request->id;
                $category = $this->categoryService->getCategoryById($id);
                if($category->parentId == null){
                    $childrenCategory = $this->categoryService->getCategoriesLevel2($id, 1);
                    if(count($childrenCategory) > 0){
                        throw new Exception('Tồn tại danh mục con nên không xóa được');
                    }
                }
                else{
                    $products = $this->productService->getProductByCategoryLV2($id, 1);
                    if(count($products) > 0){
                        throw new Exception('Tồn tại sản phẩm thuộc danh mục này nên không xóa được');
                    }
                }
                if (!$category) {
                    throw new Exception('Danh mục không tồn tại');
                }
                $respose = $category->delete();
                if (!$respose) {
                    throw new Exception('Lưu dữ liệu thất bại');
                }
                return redirect()->back()
                    ->with('success', 'Xóa danh mục ' . $category->name . ' thành công!');
            } else {
                throw new Exception('Method không phù hợp');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('fail', 'Xóa danh mục thất bại! ' . $e->getMessage());
        }
    }
    
    public function getLvl2CategoriesAPI($level1Id){
        $lvl2Categories = Category::where('parentId', $level1Id)->get();
        return $lvl2Categories->toJson();
    }

    public function updateStatus(Request $request){
        $request = $request->all();
        $categoryId = (int)$request["id"];
        $newCategoryStatus = (boolean)$request["status"];
        $category = $this->categoryService->updateStatusCategory($categoryId, $newCategoryStatus);
        return $category->toJson();
    }
    
}
