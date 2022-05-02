<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceCategory;
use Optix\Media\HasMedia;
use DateTimeInterface;
use Illuminate\Support\Facades\URL;

class Service extends Model
{
    use HasMedia;
    protected $table = "services";
    protected $fillable = [
        'name',
        'categoryId',
        'categoryIdLv2',
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
        return ServiceCategory::where('parentId', $catLvl1Id)->get();
    }

    public function getCategoryLv1Name()
    {
        return ServiceCategory::find($this->categoryId)->name;
    }

    public function getCategoryLv2Name()
    {
        return ServiceCategory::find($this->categoryIdLv2)->name;
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
