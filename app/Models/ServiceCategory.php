<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $table ="servicecategories";
    public function Products()
    {
        return $this->hasMany("App\Models\Service","categoryId","id");
    }
    public function level2Categories($catId)
    {
        return $this->where('parentId', $catId)->get();
    }
    public function parentName(){
        return $this->where('id', $this->parentId)->value('name');
    }
}
