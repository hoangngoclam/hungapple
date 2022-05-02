<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getCategoriesLevel2($level2Id, $number)
    {
        return Category::get()->where('parentId', $level2Id)->take($number);
    }

    public function getShowCategoriesLevel2($parentId)
    {
        return Category::select('id','name')->where(['parentId' => $parentId, "show_flag" => 1 ])->get()->toArray();
    }

    public function getArrCategoriesLevel2($parentId)
    {
        return Category::select('id','name')->where('parentId', $parentId)->get()->toArray();
    }

    public function getCategories()
    {
        return Category::all();
    }

    public function getCategoryLevel2ByIdLevel1($parentId)
    {
        return Category::where('id', $parentId)->first();
    }

    public function getCategoryById($id)
    {
        return Category::where('id', $id)->first();
    }

    public function getAllCategoriesLevel1()
    {
        return Category::get()->where('parentId', null);
    }

    public function getArrCategoriesLevel1()
    {
        return Category::select('id','name')->where('parentId', null)->get()->toArray();
    }

    public function getShowCategoriesLevel1()
    {
        return Category::select('id','name')->where(['parentId' => null, "show_flag" => 1 ])->get()->toArray();
    }

    public function getAllCategoriesLevel2($level2Id)
    {
        return Category::get()->where('parentId', $level2Id);
    }

    public function createCategory($data)
    {
        $result = null;
        $category = new Category();
        $category->parentId = $data['parentId'];
        $category->name = $data['name'];
        $category->meta_title = $data['meta_title'];
        $category->meta_desc = $data['meta_desc'];
        $category->meta_keywords = $data['meta_keywords'];
        $response = $category->save();
        if($response){
            $result = $category;
        } 
        return $result;
    }
    public function updateCategory($data) {
        $result = null;
        $category = $this->getCategoryById($data['id']);
        $category->parentId = $data['parentId'];
        $category->name = $data['name'];
        $category->meta_title = $data['meta_title'];
        $category->meta_desc = $data['meta_desc'];
        $category->meta_keywords = $data['meta_keywords'];
        $response = $category->save();
        if($response){
            $result = $category;
        } 
        return $result;
    }

    public function updateStatusCategory($id, $status) {
        $result = null;
        $category = $this->getCategoryById($id);
        $category->show_flag = $status;
        $response = $category->save();
        if($response){
            $result = $category;
        } 
        return $result;
    }

}
