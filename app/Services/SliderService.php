<?php

namespace App\Services;

use App\Models\Slider;

class SliderService
{
    public function getSliders($number = null)
    {
        if ($number == null) {
            return Slider::all();
        }
        return Slider::where('status', 1)->take($number)->get();
    }

    public function getSliderById($id = null)
    {
        $slider = null;
        if (isset($id) && $id) {
            $slider = Slider::find($id);
            return  $slider;
        }
        return $slider;
    }
}
