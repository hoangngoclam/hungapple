<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ServiceCategoryService;
use App\Services\ProductService;
use App\Services\RepairServiceService;
use App\Services\SliderService;
use App\Services\OrderService;
use App\Services\MediaService;

class BaseController extends Controller
{
    public $productService;
    public $repairServiceService;
    public $brandService;
    public $categoryService;
    public $serviceCategoryService;
    public $sliderService;
    public $orderService;
    public $mediaService;
    public function __construct()
    {
        $this->productService = new ProductService();
        $this->repairServiceService = new RepairServiceService();
        $this->brandService = new BrandService();
        $this->categoryService = new CategoryService();
        $this->serviceCategoryService = new ServiceCategoryService();
        $this->sliderService = new SliderService();
        $this->orderService = new OrderService();
        $this->mediaService = new MediaService();
    }
}
