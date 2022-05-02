<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Session;
use App\Services\DeliveryService;
use App\Services\CheckoutService;
use Gloudemans\Shoppingcart\Facades\Cart;


class CheckoutController extends BaseController
{
    protected $deliveryService;
    protected $checkoutService;

    public function __construct(DeliveryService $deliveryService, CheckoutService $checkoutService)
    {
        $this->deliveryService = $deliveryService;
        $this->checkoutService = $checkoutService;
        parent::__construct();
    }

    public function checkout()
    {
        $listProvince = $this->deliveryService->getAllProvince();
        return view('client.pages.checkout', ['listProvince' => $listProvince]);
    }

    public function completeOrder()
    {
        return view('client.pages.order-completed');
    }

    //shop list
    public function postCheckout(Request $request){

        $validator = $request->validateWithBag(
            'checkout',
            [
                'name' => 'bail|required|min:2',
                'phone' => 'bail|required|min:8',
                'province' => 'bail|required|min:2',
                'district' => 'bail|required|min:2',
                'ward' => 'bail|required|min:2',
                'billing_address' => 'bail|required|min:2',
            ]
        );

        if(Cart::count()) {
            //order
            $user = Session::get('user');
            $userId = $user['id'];

            $userName = $request->name;

            $phoneNumber = $request->phone;
            $idProvince = $request->province;
            $idDistrict = $request->district;
            $idWard = $request->ward;

            $province = $this->deliveryService->getProvinceById($idProvince)->name;
            $district = $this->deliveryService->getDistrictById($idDistrict)->name;
            $ward = $this->deliveryService->getWardById($idWard)->name;
            $billingAddress = $request->billing_address;

            $address = $billingAddress .', '.$ward .', '. $district .', '.$province;

            $subTotal = intval(str_replace(array(','), '', Cart::subtotal()));

            $subTotal = ($subTotal != 0 ) ? $subTotal : 0;

            if($subTotal == 0){
                return redirect('/cart');
            }
            $infoAdd = $request->info_add;

            $payment = $request->payment_option;

            $order = $this->checkoutService->saveOrder($userId, $phoneNumber, $address, $userName, $infoAdd, $payment);

            //orderDetail

            $orderId = $order->id;

            if(Cart::content() != null){
                foreach (Cart::content() as $cartItem) {
                    $productId = $cartItem->id;
                    $quantity = $cartItem->qty;
                    $this->checkoutService->saveOrderDetail($orderId, $productId, $quantity);
                    $dataSendEmail = $order->toArray();
                    $this->emailService->sendEmail(
                            env('MAIL_RECEIVE'),
                            date("d/m/Y H:i:s") . ' | hungapple.com | Đơn Hàng Mới',
                            "client.email.email-order",
                            $dataSendEmail
                    );
                }
                Cart::destroy();
            }
            return redirect('/order-completed');
        }
        return redirect('/cart');
    }

    //delivery
    public function selectDelivery(Request $request){
        $action = $request->action;
        $maId = $request->ma_id;
        if($action){
            $output = '';
            if($action == "province"){
                $output = '<option value="">Quận/ Huyện</option>';
                $selectDistrict = $this->deliveryService->getDistrictByIdProvice($maId);
                foreach($selectDistrict as $district){
                    $output .= '<option value="'.$district->maqh.'">'.$district->name.'</option>';
                }
            }else{
                $output = '<option value="">Phường/ Xã</option>';
                $selectWard = $this->deliveryService->getWardByIdDistrict($maId);
                foreach($selectWard as $ward){
                    $output .= '<option value="'.$ward->xaid.'">'.$ward->name.'</option>';
                }
            }
        }
        return $output;
    }

}
