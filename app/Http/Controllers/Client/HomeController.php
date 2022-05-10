<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $serviceIdEK = 7;

        $take = 8;
        $categoryLevel1 = $this->categoryService->getShowCategoriesLevel1();
        $categorys = array_map(function($item) use($take){
            $childrenCategory = $this->categoryService->getShowCategoriesLevel2($item["id"]);
            $childrenCategory = array_map(function($childCategory) use($take) {
                $products = $this->productService->getProductByCategoryLV2($childCategory["id"], $take);
                $childCategory["products"] = $products;
                return $childCategory;
            }, $childrenCategory);
            $item["childrenCategory"] = $childrenCategory;
            return $item;
        }, $categoryLevel1);

        $serviceCategoryLevel1 = $this->serviceCategoryService->getShowCategoriesLevel1();
        $serviceCategorys = array_map(function($item) use($take){
            $childrenCategory = $this->serviceCategoryService->getShowCategoriesLevel2($item["id"]);
            $childrenCategory = array_map(function($childCategory) use($take) {
                $repairService = $this->repairServiceService->getServiceByCategoryLV2($childCategory["id"], $take);
                $childCategory["services"] = $repairService;
                return $childCategory;
            }, $childrenCategory);
            $item["childrenCategory"] = $childrenCategory;
            return $item;
        }, $serviceCategoryLevel1);

        $arrayServiceCategoryIdLv2EK = [8 => 'Ép kính Iphone'];
        $arrayServicesEK = [];
        $nameServicesEK = 'ServicesEK';
        foreach ($arrayServiceCategoryIdLv2EK as $key => $value) {
            ${$nameServicesEK . $key} = $this->repairServiceService->getServiceByCategoryIdAndCategoryIdLv2($take, $serviceIdEK, $key);
            $arrayServicesEK[$key] = ${$nameServicesEK . $key};
        }

        $sliders = $this->sliderService->getSliders(config('constants.slider.MAX_ITEMS'));
        $brands = $this->brandService->getBrands();
        // dd($arrayProducts);
        return view(
            'client.pages.home',
            [
                'arrayCategory' => $categorys,
                'arrayServiceCategory' => $serviceCategorys,
                'sliders' => $sliders,
                'brands' => $brands,
            ]
        );
    }

    public function about()
    {
        return view('client.pages.about');
    }

    public function contact()
    {
        return view('client.pages.contact');
    }
}
