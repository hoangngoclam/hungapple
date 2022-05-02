<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = "orderdetails";
    public function Product()
    {
        return $this->belongsTo("App\Models\Product","productId");
    }
    public function Order()
    {
        return $this->belongsTo("App\Models\Order","orderId");
    }
}
