<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderItem;
use App\Inventory;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmed;
use DB;

class OrdersController extends Controller
{
    public function submitOrder(Request $request) {
    	$email = $request->email;
    	$address = $request->address;
        $po_number = $request->po_number;
    	$user = $request->user;
    	$orders = $request->orders;
    	$token = md5(microtime().rand());
    	$failed = [];
    	foreach ($orders as $key => $value) {
    		$check = Inventory::select('id', 'available_units')->where('customer_style', $value['customer_style'])->first();
    		if ((int)$check->available_units < (int)$value['quantity_ordered']) {
    			array_push($failed, $value);
    		}
    	}

    	if (count($failed)) {
    		$result = 'not-enough';
    		return compact('failed', 'result');
    	}

    	$res = new Order;
    	$res->po_number = $po_number;
    	$res->ship_to = $address['ship_to'];
    	$res->address = $address['address'];
    	$res->city = $address['city'];
    	$res->state = $address['state'];
    	$res->zip_code = $address['zip_code'];
    	$res->token = $token;
        $res->user_id = $user['id'];
        $res->user_name = $user['name'];
        $res->email = $user['email'];
        $res->customer_number = $user['customer_number'];
        $res->status = 'needs_entered';
    	$res->save();

    	if ($res) {
            $i=0;
            $j=0;
            $orderItems = [];
    		foreach ($orders as $key => $value) {
    			$r = new OrderItem;
    			$r->order_id = $res->id;
    			$r->pai_style = $value['booking_style'];
    			$r->pai_color = $value['pai_color'];
    			$r->pai_variation = $value['booking_color'];
    			$r->customer_style = $value['customer_style'];
    			$r->customer_color = $value['customer_color'];
    			$r->size = $value['size'];
    			$r->quantity_ordered = $value['quantity_ordered'];
    			$r->unit_price = $value['retail_price'];
    			$r->total_price = $value['total_price'];
    			if ($r->save()) {
                    array_push($orderItems, $r);
                    $i++;
                }
                $j++;
    		}
            if ($i == $j) {
                $res->order_items = $orderItems;
                Mail::to($user['email'])
                     ->send(new OrderConfirmed($res));

        		$result = 'success';
        		return compact('res', 'result');
            }
    	} else {
    		return 'failed';
    	}
    }

    public function getOrder(Request $request) {
        $token = $request->token;

        $res = Order::select()->where('token', $token)->first();
        if ($res) {
            $r = OrderItem::select()->where('order_id', $res->id)->get();
            $res->items = $r;
            return $res;
        }
    }

    public function getOrders(Request $request) {
        $filter = $request->filter;

        if ($filter == 'All') {
            // $res = DB::table('orders')
            //             ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            //             ->select('orders.*',)
            //             ->orderBy('orders.id', 'DESC')
            //             ->get();
            $res = Order::all();
        } else {
            // $res = DB::table('orders')
            //             ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            //             ->select('orders.*', 'order_items.* as items')
            //             ->where('orders.status', 'needs_entered')
            //             ->orderBy('orders.id', 'DESC')
            //             ->get();
            $res = Order::select()->where('status', $filter)->get();
        }
        return $res;
    }

    public function changeStatus(Request $request) {
        $order = $request->order;
        $status = $request->status;

        $res = Order::find($order['id']);
        $res->status = $status;
        $res->save();
        return $res;
    }
}
