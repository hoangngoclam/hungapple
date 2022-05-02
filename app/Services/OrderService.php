<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;

class OrderService
{
    public function getOrders(){
        $orders = Order::orderBy('created_at','desc')->get();

        return $orders;
    }

    public function getOrdersDetailByOrderId($orderId = null){
        $ordersDetail = null;
        if ($orderId !== null) {
            $ordersDetail = OrderDetail::where('orderId', $orderId)->orderBy('created_at','desc')->get();
        }

        return $ordersDetail;
    }

    public function getOrderById($id = null){
        $order = null;
        if ($id !== null) {
            $order = Order::find($id);
        }

        return $order;
    }

    public function deleteOrderByIdAndAllOrderDetail($orderId = null){
        try {
            $order = null;
            $ordersDetail = null;
            $order = $this->getOrderById($orderId);
            if ($order !== null) {
                $ordersDetail = $this->getOrdersDetailByOrderId($orderId);
                if ($ordersDetail !== null) {
                    foreach($ordersDetail as $orderDetail) {
                        if(!$orderDetail->delete()) {
                            return false;
                        }
                    }
                }
                if(!$order->delete()){
                    return false;
                }
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getOrderDetailById($id = null){
        $orderDetail = null;
        if ($id !== null) {
            $orderDetail = OrderDetail::find($id);
        }

        return $orderDetail;
    }

    public function deleteOrderDetailById($id = null){
        try {
            $orderDetail = null;
            $orderDetail = $this->getOrderDetailById($id);
            if ($orderDetail !== null) {
                if(!$orderDetail->delete()){
                    return false;
                }
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
