<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Exception;
use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\Brand;
use App\Models\Product;

class OrderController extends BaseController
{
    public function index() {
        $pageName = "Quản Lý Đơn Hàng";
        $orders = $this->orderService->getOrders();
        return view('admin.pages.order.index', ['orders' => $orders, 'data' => ['pageName' => $pageName]]);
    }

    public function add(Request $request)
    {

        $pageName = "Thêm đơn hàng mới";
        if ($request->isMethod('POST')) {
            try {
                // Validation
                $validator  = $request->validateWithBag(
                    'order',
                    [
                        'nameUser' => 'required',
                    ],
                    [
                        'required' => ':attribute không được để trống.',
                    ],
                    [
                        'nameUser' => 'Họ tên',
                    ]
                );
                $order = new Order();              // Get all parameters from request except some parameters
                $order->userId = '30';
                $order->nameUser = $request->nameUser;
                $order->phoneNumber = $request->phoneNumber;
                $order->address = $request->address;
                $order->infoAdd = $request->infoAdd;
                $order->payment_method = $request->payment_method;
                $order->status = $request->status;
                // Update DB
                if (!$order->save()) {
                    return redirect()->back()
                    ->with('fail', 'Lưu dữ liệu thất bại! ')->withInput();
                }
                return redirect()->route('admin.editOrderGet', ['id' => $order->id])
                    ->with('success', 'Cập nhật đơn hàng ' . $order->id . ' thành công!');
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('fail', 'Cập nhật  đơn hàng thất bại! ' . $e->getMessage())->withInput();
            }
        }
        return view('admin.pages.order.add', compact('pageName'));
    }

    public function edit(Request $request)
    {
        $pageName = "Chỉnh sửa thương hiệu";
        $order = $this->orderService->getOrderById($request->id);
        // Not exist in DB
        if (!$order) {
            return redirect()->back()->with('Đơn hàng không tồn tại: ' . $request->id)->withInput();
        }
        if ($request->isMethod('POST')) {
            try {
                // Validation
                $validator  = $request->validateWithBag(
                    'order',
                    [
                        'nameUser' => 'required',
                    ],
                    [
                        'required' => ':attribute không được để trống.',
                    ],
                    [
                        'nameUser' => 'Họ tên',
                    ]
                );
                // Get all parameters from request except some parameters
                $order->nameUser = $request->nameUser;
                $order->phoneNumber = $request->phoneNumber;
                $order->address = $request->address;
                $order->infoAdd = $request->infoAdd;
                $order->payment_method = $request->payment_method;
                $order->status = $request->status;
                // Update DB
                if (!$order->save()) {
                    throw new Exception('Lưu dữ liệu thất bại');
                }
                return redirect()->route('admin.editOrderGet', ['id' => $order->id])
                    ->with('success', 'Cập nhật đơn hàng ' . $order->id . ' thành công!');
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('fail', 'Cập nhật  đơn hàng thất bại! ' . $e->getMessage())->withInput();
            }
        }
        return view('admin.pages.order.edit', compact('order', 'pageName'));
    }

    public function delete(Request $request)
    {
        if ($request->isMethod('POST')) {
            $id = $request->id;
            $respose = $this->orderService->deleteOrderByIdAndAllOrderDetail($id);

            if (is_string($respose)) {
                return redirect()->back()->with('fail', 'Xóa thất bại! ' . $respose);
            }
            if (!$respose) {
                return redirect()->back()->with('fail', 'Đơn hàng không tồn tại! ' . $respose);
            }
            return redirect()->back()->with('success', 'Xóa thành công!');
        } else {
            throw new Exception('Method không phù hợp');
        }
    }


    public function orderDetail(Request $request)
    {
        $id = $request->id;
        $pageName = "Chi tiết đơn hàng . $id";
        $ordersDetail = $this->orderService->getOrdersDetailByOrderId($id);

        // Not exist in DB
        if (!$ordersDetail) {
            throw new Exception('Không có đơn hàng nào: ' . $id);
        }

        foreach($ordersDetail as $key => $orderDetail) {
            $ordersDetail[$key]->product = Product::find($orderDetail->productId);
        }

        return view('admin.pages.orderDetail.index', compact('ordersDetail', 'pageName','id'));
    }

    public function deleteOrderDetail(Request $request)
    {
        if ($request->isMethod('POST')) {
            $id = $request->id;
            $respose = $this->orderService->deleteOrderDetailById($id);

            if (is_string($respose)) {
                return redirect()->back()->with('fail', 'Xóa thất bại! ' . $respose);
            }
            if (!$respose) {
                return redirect()->back()->with('fail', 'Đơn hàng không tồn tại! ' . $respose);
            }
            return redirect()->back()->with('success', 'Xóa thành công!');
        } else {
            throw new Exception('Method không phù hợp');
        }
    }

    public function addOrderDetail(Request $request)
    {
        $id = $request->id;
        $pageName = "Thêm chi tiết đơn hàng";
        if ($request->isMethod('POST')) {
            try {
                $orderDetail = new OrderDetail();
                $orderDetail->orderId = $request->orderId;
                $product = Product::find($request->productId);
                if($product == null){
                    return redirect()->back()->with('fail', 'Id sản phẩm không tồn tại! ');
                }
                $orderDetail->productId = $request->productId;

                $orderDetail->quantity = $request->quantity;
                if (!$orderDetail->save()) {
                    return redirect()->back()->with('fail', 'Lưu chi tiết đơn hàng thất bại! ');
                }
                return redirect()->route('admin.editOrderDetailGet', ['id' => $orderDetail->id])
                    ->with('success', 'Thêm chi tiết đơn hàng với id sản phẩm ' . $orderDetail->productId . ' thành công!');
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('fail', 'Thêm chi tiết đơn hàng thất bại! ' . $e->getMessage());
            }
        }
        return view('admin.pages.orderDetail.add', compact('pageName','id'));
    }

    public function editOrderDetail(Request $request)
    {
        $id = $request->id;
        $orderDetail = OrderDetail::find($id);

        $pageName = "Chỉnh sửa chi tiết đơn hàng";
        if ($request->isMethod('POST')) {
            try {
                $product = Product::find($request->productId);
                if($product == null){
                    return redirect()->back()->with('fail', 'Id sản phẩm không tồn tại! ');
                }
                $orderDetail->productId = $request->productId;
                $orderDetail->quantity = $request->quantity;
                if (!$orderDetail->save()) {
                    return redirect()->back()->with('fail', 'Lưu chi tiết đơn hàng thất bại! ');
                }
                return redirect()->route('admin.editOrderDetailGet', ['id' => $orderDetail->id])
                    ->with('success', 'Chỉnh sửa chi tiết đơn hàng với id sản phẩm ' . $orderDetail->productId . ' thành công!');
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('fail', 'Chỉnh sửa chi tiết đơn hàng thất bại! ' . $e->getMessage());
            }
        }
        return view('admin.pages.orderDetail.edit', compact('pageName','orderDetail'));
    }
}
