<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{

    public function getAll()
    {
        // return Product::all();
        return Product::where('status', 1)->get();
    }

    public function getProductByCategoryId($categoryId, $take)
    {
        $products = null;
        if (isset($categoryId) && $categoryId) {
            // $products = Product::where('categoryId', $categoryId)->get()->take($take);
            $products = Product::where([['categoryId', $categoryId],['status', 1]])->get()->take($take);
        }

        return $products;
    }

    public function getProductByCategoryLV2($categoryLV2Id, $take)
    {
        $products = null;
        if (isset($categoryLV2Id) && $categoryLV2Id) {
            // $products = Product::where('categoryId', $categoryId)->get()->take($take);
            $products = Product::where([['categoryIdLv2', $categoryLV2Id],['status', 1]])->get()->take($take);
        }

        return $products;
    }

    public function getProductByCategoryIdAndCategoryIdLv2($take, $categoryId = null, $categoryIdLv2 = null)
    {
        $products = null;
        if (!is_null($categoryId)&& !is_null($categoryIdLv2)) {
            $products = Product::where([
            	'status' => 1,
                'categoryId' => $categoryId, 
                'categoryIdLv2' => $categoryIdLv2
            ])->get()->take($take);
        }

        return $products;
    }

    public function getProductByCategoryIdAndBrandId($categoryId, $take, $brandId)
    {
        $products = null;
        if (isset($categoryId) && $categoryId && isset($brandId) && $brandId) {
            $products = Product::where([['categoryId', $categoryId], ['brandId', $brandId]])->get()->take($take);
        }

        return $products;
    }

    // Get product is actived
    public function productDetail($id, $isCheckStatus = true)
    {
        if ($isCheckStatus) {
            return Product::where([['id', $id], ['status', 1]])->first();
        }
        return Product::findOrFail($id);
    }

    public function getShopProducts($keyword, $categoryLv1Id, $categoryLv2Id, $brands, $sortBy, $itemsPerPage)
    {
        $whereCond = [];
        array_push($whereCond, ['status', '1']); // Products are actived.
        if (isset($keyword) && !empty($keyword)) {
            array_push($whereCond, ['name', 'like', "%$keyword%"]);
        }

        if (isset($categoryLv1Id) && !empty($categoryLv1Id)) {
            array_push($whereCond, ['categoryId', '=', $categoryLv1Id]);
        }

        if (isset($categoryLv2Id) && !empty($categoryLv2Id)) {
            array_push($whereCond, ['categoryIdLv2', '=', $categoryLv2Id]);
        }

        $sort = $this->getSortCondition($sortBy);

        $conditionsWhereIn = [];
        if (isset($brands) && !empty($brands)) {
            $brandFilter = explode(',', $brands);
            $conditionsWhereIn = ['column' => 'brandId', 'values' => $brandFilter];
        }
        $builder = Product::where($whereCond);
        if (count($conditionsWhereIn)) {
            $builder = $builder->whereIn($conditionsWhereIn['column'], $conditionsWhereIn['values']);
        }
        return $builder->orderBy($sort['by'], $sort['type'])->paginate($itemsPerPage);
    }

    public function getSortCondition($sortBy)
    {
        $sortBy = isset($sortBy) && $sortBy && in_array($sortBy, array_keys(config('shop_config.sort_by'))) ? $sortBy : 'default';
        $getSort = config('shop_config.sort_by.' . $sortBy);
        return $getSort;
    }

    public function getQuantity($id)
    {
        return Product::select('quantity')->where('id', $id)->get()[0]->quantity;
    }

    public function deleteProduct($id=null)
    {
        if(!is_null($id)){
            Product::where('id', $id)->delete();
            return $id;
        }
        else{
            throw new Exception('Delete product fail');
        }
    }
}
