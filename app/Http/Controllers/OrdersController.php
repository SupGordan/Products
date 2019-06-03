<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Status;

class OrdersController extends Controller
{
    /**
     * Create order method
     * /create-order
     *
     * @param Request $request "products:json{products_name:quantity} && address:string && time_delivery:date_format{Y-m-d H:i}"
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
        DB::beginTransaction();
        try {
            $order = new Order;
            $order-> address        = $request->get('address');
            $order-> time_delivery  = $request->get('time_delivery').":00";
            $order-> status_id      = Status::NEW_ORDER;
            $order-> save();
            $cart = json_decode($request->get('products'));
            if (!is_object($cart)) throw new \Exception('Wrong products');
            foreach ($cart as $name => $quantity) {
                if (!is_string($name) || !is_int($quantity)) throw new \Exception('Wrong products array');
                $cartItem = new Cart;
                $cartItem-> order_id        = $order->id;
                $cartItem-> product_name    = $name;
                $cartItem-> quantity        = $quantity;
                $cartItem-> save();
            }
            DB::commit();
            return response()->json(["status" => "Order added"], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["status" => "Order not added", 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Change status order method
     * /change-status
     *
     * @param Request $request "id:int && status_id:int"
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request) {
        $rules = array(
            'id'        =>  'required|integer',
            'status_id' =>  'required|integer',
        );
        $validation = Validator::make($request->all(), $rules);
        if($validation->fails()) {
            return response()->json($validation->messages(), 400);
        }
        try {
            $order = Order::find($request->get('id'));
            if (!$order) throw new \Exception('Order not found');
            $status = Status::find($request->get('status_id'));
            if (!$status) throw new \Exception('Status not found');
            $order-> status_id = $request->get('status_id');
            $order-> save();
            return response()->json(["status" => "Status changed"], 200);
        } catch (\Exception $e) {
            return response()->json(["status" => "Status not changed", 'error' => $e->getMessage()], 400);
        }
    }
}
