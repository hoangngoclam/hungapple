<?php

namespace App\Services;

use App\Models\Brand;

class BrandService
{
    public function getBrands($number = null)
    {
        if (isset($number) && $number) {
            return Brand::all();
        }
        return Brand::get()->take($number);
    }
    public function getBrandById($id = null)
    {
        $brand = null;
        if (isset($id) && $id) {
            $brand = Brand::find($id);
            return  $brand;
        }
        return $brand;
    }
    
}
