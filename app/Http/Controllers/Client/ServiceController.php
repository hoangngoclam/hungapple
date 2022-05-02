<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class ServiceController extends BaseController
{
    public function serviceDetail($id)
    {
        $service = $this->repairServiceService->ServiceDetail($id);
        $servicesRelate = $this->repairServiceService->getServiceByCategoryIdAndCategoryIdLv2(8, $service->categoryId, $service->categoryIdLv2);;
        return view('client.pages.service-detail', compact('service', 'servicesRelate'));
    }
    public function shopAll(Request $request)
    {
        $sortBy = $request->sortBy;
        $keyword = $request->keyword;
        $brands = $request->brand;
        $categoryLv1Id = $request->cat1;
        $categoryLv2Id = $request->cat2;
        $itemsPerPage = config('constants.pagination.ITEMS_PER_PAGE');
        $services = $this->repairServiceService->getShopServices($keyword, $categoryLv1Id, $categoryLv2Id, $brands, $sortBy, $itemsPerPage);
        return view('client.pages.service-shop', compact('services'));
    }
}
