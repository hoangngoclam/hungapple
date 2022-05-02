<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Optix\Media\HasMedia;
use DateTimeInterface;
use Illuminate\Support\Facades\URL;

class Product extends Model
{
    use HasMedia;
    protected $table = "products";
    protected $fillable = [
        'name',
        'categoryId',
        'categoryIdLv2',
        'SKU',
        'price',
        'promotionPrice',
        'technicalPrice',
        'brandId',
        'quantity',
        'desc',
        'title',
        'meta_desc',
        'meta_keywords',
        'meta_title'
    ];
    public function firstImage()
    {
        return explode("|", $this->images)[0];
    }

    public function getCategoriesLvl2($catLvl1Id)
    {
        return Category::where('parentId', $catLvl1Id)->get();
    }

    public function getCategoryLv1Name()
    {
        return Category::find($this->categoryId)->name;
    }

    public function getCategoryLv2Name()
    {
        return Category::find($this->categoryIdLv2)->name;
    }

    public function getTemporaryUrl($mediaId, $mediaName, DateTimeInterface $expiration, array $options = [])
    {
        return URL::temporarySignedRoute(
            'private-storage',
            $expiration,
            ['media' => $mediaId, 'filename' => $mediaName]
        );
    }
}
