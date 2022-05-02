<?php

namespace App\Services;

use App\Models\Service;

class RepairServiceService
{

    public function getAll()
    {
        return Service::all();
    }

    public function getServiceByCategoryId($categoryId, $take)
    {
        $services = null;
        if (isset($categoryId) && $categoryId) {
            $services = Service::where('categoryId', $categoryId)->get()->take($take);
        }

        return $services;
    }

    public function getServiceByCategoryLV2($categoryLV2Id, $take)
    {
        $products = null;
        if (isset($categoryLV2Id) && $categoryLV2Id) {
            $products = Service::where([['categoryIdLv2', $categoryLV2Id],['status', 1]])->get()->take($take);
        }

        return $products;
    }

    public function getServiceByCategoryIdAndCategoryIdLv2($take, $categoryId = null, $categoryIdLv2 = null)
    {
        $services = null;
        if (!is_null($categoryId)&& !is_null($categoryIdLv2)) {
            $services = Service::where([
                'categoryId' => $categoryId, 
                'categoryIdLv2' => $categoryIdLv2
            ])->get()->take($take);
        }
        return $services;
    }

    public function getServiceByCategoryIdAndBrandId($categoryId, $take, $brandId)
    {
        $services = null;
        if (isset($categoryId) && $categoryId && isset($brandId) && $brandId) {
            $services = Service::where([['categoryId', $categoryId], ['brandId', $brandId]])->get()->take($take);
        }

        return $services;
    }

    //Quick View service
    public function ServiceDetail($id)
    {
        return Service::findOrFail($id);
    }

    public function getShopServices($keyword, $categoryLv1Id, $categoryLv2Id, $brands, $sortBy, $itemsPerPage)
    {
        $whereCond = [];

        if (isset($keyword) && !empty($keyword)) {
            array_push($whereCond, ['name', 'like', "%$keyword%"]);
        }

        if (isset($categoryLv1Id) && !empty($categoryLv1Id)) {
            array_push($whereCond, ['categoryId', '=', $categoryLv1Id]);
        }

        if (isset($categoryLv2Id) && !empty($categoryLv2Id)) {
            array_push($whereCond, ['categoryIdLv2', '=', $categoryLv2Id]);
        }

        $sort = $this->getSortContidion($sortBy);

        $conditionsWhereIn = [];
        if (isset($brands) && !empty($brands)) {
            $brandFilter = explode(',', $brands);
            $conditionsWhereIn = ['column' => 'brandId', 'values' => $brandFilter];
        }
        $builder = Service::where($whereCond);
        if (count($conditionsWhereIn)) {
            $builder = $builder->whereIn($conditionsWhereIn['column'], $conditionsWhereIn['values']);
        }
        return $builder->orderBy($sort['by'], $sort['type'])->paginate($itemsPerPage);
    }

    public function getSortContidion($sortBy)
    {
        $sortBy = isset($sortBy) && $sortBy && in_array($sortBy, array_keys(config('shop_config.sort_by'))) ? $sortBy : 'default';
        $getSort = config('shop_config.sort_by.' . $sortBy);
        return $getSort;
    }

    public function deleteService($id=null)
    {
        if(!is_null($id)){
            Service::where('id', $id)->delete();
            return $id;
        }
        else{
            throw new Exception('Delete service fail');
        }
    }
}
