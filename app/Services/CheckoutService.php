<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;

class CheckoutService
{
    protected $product;
    protected $category;
    protected $user;
    public function __construct(Order $order, OrderDetail $orderDetail, User $user)
    {
        $this->order = $order;
        $this->orderDetail = $orderDetail;
        $this->user = $user;
    }

    public function saveOrder($userId, $phoneNumber, $address, $userName, $infoAdd, $paymentMethod){
        $this->order->userId = $userId;
        $this->order->nameUser = $userName;
        $this->order->phoneNumber = $phoneNumber;
        $this->order->address = $address;
        $this->order->infoAdd = $infoAdd;
        $this->order->payment_method = $paymentMethod;
        $this->order->save();
        $newUser = New User();
        $user = $newUser::find($userId);
        $user->name = $userName;
        $user->phoneNumber = $phoneNumber;
        $user->address = $address;
        $user->save();
        return $this->order;
    }

    public function saveOrderDetail($orderId, $productId, $quantity){
        $newOrderDetail = new OrderDetail;
        $newOrderDetail->orderId = $orderId;
        $newOrderDetail->productId = $productId;
        $newOrderDetail->quantity = $quantity;
        $newOrderDetail->save();
        return $newOrderDetail;
    }


}
