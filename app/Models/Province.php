<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = "province";
    public function District()
    {
        return $this->hasMany("App\Models\District","matp","maqh");
    }
}
