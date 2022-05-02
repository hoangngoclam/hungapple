<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $table = "ward";
    //Tinh
    public function District()
    {
        return $this->belongsTo("App\Models\District", "maqh");
    }
}
