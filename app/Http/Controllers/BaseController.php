<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\SliderService;
use App\Services\RepairServiceService;
use App\Services\ServiceCategoryService;
use App\Services\EmailService;

class BaseController extends Controller
{
    public $productService;
    public $brandService;
    public $categoryService;
    public $sliderService;
    public $repairServiceService;
    public $serviceCategoryService;
    public $emailService;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->brandService = new BrandService();
        $this->categoryService = new CategoryService();
        $this->sliderService = new SliderService();
        $this->repairServiceService = new RepairServiceService();
        $this->serviceCategoryService = new ServiceCategoryService();
        $this->emailService = new EmailService();

        $brands =  $this->brandService->getBrands();
        // Get phone components categories
        $categories = $this->categoryService->getCategoriesLevel2(2, 15);
        // Get phone accessories categories
        $accCategories = $this->categoryService->getCategoriesLevel2(3, 15);

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

        $serCategoryLevel1 = $this->serviceCategoryService->getArrCategoriesLevel1();
        $serviceCategorys = array_map(function($item){
            $childrenCategory = $this->serviceCategoryService->getArrCategoriesLevel2($item["id"]);
            $item["childrenCategory"] = $childrenCategory;
            $item["type"] = "service";
            return $item;
        }, $serCategoryLevel1);

        $productCategoryLevel1 = $this->categoryService->getArrCategoriesLevel1();
        $productCategorys = array_map(function($item){
            $childrenCategory = $this->categoryService->getArrCategoriesLevel2($item["id"]);
            $item["childrenCategory"] = $childrenCategory;
            $item["type"] = "product";
            return $item;
        }, $productCategoryLevel1);

        $shopPhoneNumber = "093-318-7879";
        $shopEmail = "hungapple@gmail.com";
        $shopAddress = "176 Phan Đình Phùng - Phường 2 - TP. Đà Lạt - Lâm Đồng";
        $listAllCategory = array_merge($productCategorys, $serviceCategorys);
        // Sharing is caring
        View::share(compact('shopPhoneNumber', 'shopEmail', 'shopAddress', 'brands', 'categories', 'allCategoriesProcessed', 'accCategories', 'serviceCategorys', 'productCategorys','listAllCategory'));
    }
}
