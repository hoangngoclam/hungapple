<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;

class DeliveryService
{
    protected $province, $district, $ward;

    public function __construct(Province $province, District $district, Ward $ward)
    {
        $this->province = $province;
        $this->district = $district;
        $this->ward     = $ward;
    }

    public function getAllProvince(){
        $listProvince = $this->province::all()->sortBy('name');
        return $listProvince;
    }
    public function getProvinceById($idProvince){
        $province = $this->province::where('matp', $idProvince)->first();
        return $province;
    }

    public function getDistrictByIdProvice($idProvince){
        $listDistrict = $this->district::where('matp', $idProvince)->get()->sortBy('name');
        return $listDistrict;
    }

    public function getDistrictById($idDistrict){
        $district = $this->district::where('maqh', $idDistrict)->first();
        return $district;
    }

    public function getWardByIdDistrict($idDistrict){
        $listWard = $this->ward::where('maqh', $idDistrict)->get()->sortBy('name');
        return $listWard;
    }
    public function getWardById($idWard){
        $ward = $this->ward::where('xaid', $idWard)->first();
        return $ward;
    }
}
