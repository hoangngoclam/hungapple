<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class ProductController extends BaseController
{

    public function shopAll(Request $request)
    {
        $sortBy = $request->sortBy;
        $keyword = $request->keyword;
        $brands = $request->brand;
        $categoryLv1Id = $request->cat1;
        $categoryLv2Id = $request->cat2;
        $itemsPerPage = config('constants.pagination.ITEMS_PER_PAGE');
        $products = $this->productService->getShopProducts($keyword, $categoryLv1Id, $categoryLv2Id, $brands, $sortBy, $itemsPerPage);
        $accCategories = $this->categoryService->getCategoriesLevel2(3, 15);
        return view('client.pages.shop', compact('accCategories', 'products'));
    }

    public function detail($id)
    {
        $product = $this->productService->productDetail($id);
        if (!$product) {
            abort(404);
        }
        $productsRelate = $this->productService->getProductByCategoryIdAndCategoryIdLv2(8, $product->categoryId, $product->categoryIdLv2);

        return view('client.pages.detail', compact('product', 'productsRelate'));
    }

    //Quick view product
    public function quickView($id)
    {
        $product = $this->productService->productDetail($id);
        if (!$product) {
            abort(404);
        }
        return view('client.partials.quick-view', compact('product'));
    }
}
