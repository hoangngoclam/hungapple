<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";
    public function OrderDetails()
    {
        return $this->hasMany("App\Models\OrderDetail","orderId");
    }
    public function User()
    {
        return $this->belongsTo("App\Models\User","userId","id");
    }
}
