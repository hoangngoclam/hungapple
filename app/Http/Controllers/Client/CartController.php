<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseController;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends BaseController
{
    public function cart()
    {
        return view('client.pages.cart');
    }

    public function add(Request $request)
    {
        try {
            $id = $request->id;
            $qty = $request->qty;
            $product = $this->productService->productDetail($id);
            $cartItem = Cart::search(function ($cartItem) use ($id) {
                return $cartItem->id == $id;
            });
            if ($cartItem->first()) {
                $cartQty = $cartItem->first()->qty;
                if ($cartQty + $qty > $product->quantity) {
                    return response()->json([
                        'status' => config('constants.json_response.FAIL_STATUS')
                    ], 401);
                }
            }
            if ($qty == 0 || $qty > $product->quantity) {
                return response()->json([
                    'status' => config('constants.json_response.FAIL_STATUS')
                ], 401);
            }
            Cart::add(
                [
                    "id" => $product->id,
                    "name" => $product->name,
                    "options" => ['img' => $product->getFirstMediaUrl('images', 'thumb')],
                    "qty" => $qty,
                    "price" => $product->price
                ]
            );
            // Calculate total quantity
            $totalQty = 0;
            foreach (Cart::content() as $cartItem) {
                $totalQty = $totalQty + intval($cartItem->qty);
            }
            return response()->json([
                'status' => config('constants.json_response.SUCCESS_STATUS'),
                'cartList' => json_encode(Cart::content()),
                'totalQty' => $totalQty,
                'totalPrice' => floatval(str_replace(array(','), '', Cart::subtotal())),
                'tax' => config('constants.order.SHIPPING_FEE')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => config('constants.json_response.FAIL_STATUS')
            ], 500);
        }
    }

    public function remove(Request $request)
    {
        try {
            Cart::remove($request->rowId);
            // Calculate total quantity
            $totalQty = 0;
            foreach (Cart::content() as $cartItem) {
                $totalQty = $totalQty + intval($cartItem->qty);
            }
            return response()->json([
                'status' => config('constants.json_response.SUCCESS_STATUS'),
                'cartList' => json_encode(Cart::content()),
                'totalQty' => $totalQty,
                'totalPrice' => floatval(str_replace(array(','), '', Cart::subtotal())),
                'tax' => config('constants.order.SHIPPING_FEE')
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => config('constants.json_response.FAIL_STATUS')
            ], 500);
        }
    }

    public function updateQuantity(Request $request)
    {
        try {
            $qty = $request->qty;
            $rowId = $request->rowId;
            $productId = Cart::get($rowId)->id;
            $productQty = $this->productService->getQuantity($productId);
            if ($qty == 0 || $qty > $productQty) {
                return response()->json([
                    'status' => config('constants.json_response.FAIL_STATUS')
                ], 401);
            }
            Cart::update($rowId, $qty);
            // Calculate total quantity
            $totalQty = 0;
            foreach (Cart::content() as $cartItem) {
                $totalQty = $totalQty + intval($cartItem->qty);
            }
            return response()->json([
                'status' => config('constants.json_response.SUCCESS_STATUS'),
                'cartList' => json_encode(Cart::content()),
                'totalQty' => $totalQty,
                'totalPrice' => floatval(str_replace(array(','), '', Cart::subtotal())),
                'tax' => config('constants.order.SHIPPING_FEE')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => config('constants.json_response.FAIL_STATUS')
            ], 500);
        }
    }
}
