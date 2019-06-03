<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Status;

class OrdersController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrder(Request $request) {
        $rules = array(
            'products'      =>  'required|json',
            'address'       =>  'required|string',
            'time_delivery' =>  'required|date_format:"Y-m-d H:i"|after:now'
        );
        $validation = Validator::make($request->all(), $rules);
        if($validation->fails()) {
            return response()->json($validation->messages(), 400);
        }
        $order = new Order;
        $order-> address        = $request->get('address');
        $order-> time_delivery  = $request->get('time_delivery').":00";
        $order-> status_id      = Status::NEW_ORDER;
        $order-> save();
        $cart = json_decode($request->get('products'));
        foreach ($cart as $name => $quantity) {
            $cartItem = new Cart;
            $cartItem-> order_id        = $order->id;
            $cartItem-> product_name    = $name;
            $cartItem-> quantity        = $quantity;
            $cartItem-> save();
        }
        return response()->json(["status" => "Order added"], 200);
    }
}
