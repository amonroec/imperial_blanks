<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderItem;
use App\Inventory;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmed;
use DB;
use Stripe;

class OrdersController extends Controller
{
    public function submitOrder(Request $request) {
    	$email = $request->email;
    	$order_details = $request->order_details;
        $soldTo = $order_details['sold_to'];
        $shipTo = $order_details['ship_to'];
        $po_number = $request->po_number;
    	$user = $request->user;
        $charge = $request->charge;
    	$orders = $request->orders;
    	$token = md5(microtime().rand());
    	$failed = [];
    	foreach ($orders as $key => $value) {
    		$check = Inventory::select('id', 'quantity')->where('style', $value['style'])->where('color_code', $value['color_code'])->first();
    		if ((int)$check->quantity < (int)$value['quantity_ordered']) {
    			array_push($failed, $value);
    		}
    	}

    	if (count($failed)) {
    		$result = 'not-enough';
    		return compact('failed', 'result');
    	}

    	$res = new Order;
    	$res->po_number = $order_details['po_number'];
        $res->sold_to = $soldTo;
        $res->ship_to = $shipTo;
        $res->event = $order_details['event'];
        $res->event_date = $order_details['event_date'];
        $res->ship_method = $order_details['ship_method'];
        $res->ship_date = $order_details['ship_date'];
        $res->ship_code = $order_details['ship_code'];
    	// $res->ship_to = $address['ship_to'];
    	// $res->address = $address['address'];
    	// $res->city = $address['city'];
    	// $res->state = $address['state'];
    	// $res->zip_code = $address['zip_code'];
    	$res->token = $token;
        $res->user_id = $user['id'];
        $res->user_name = $user['name'];
        $res->email = $user['email'];
        $res->customer_number = $user['customer_number'];
        $res->payment_type = 'invoice';
        $res->status = 'needs_entered';
    	$res->save();

    	if ($res) {
            $i=0;
            $j=0;
            $orderItems = [];
    		foreach ($orders as $key => $value) {
    			$r = new OrderItem;
    			$r->order_id = $res->id;
    			$r->style = $value['style'];
    			$r->color = $value['color'];
    			$r->color_code = $value['color_code'];
    			// $r->customer_style = $value['customer_style'];
    			// $r->customer_color = $value['customer_color'];
    			$r->size = $value['size'];
    			$r->quantity_ordered = $value['quantity_ordered'];
    			$r->unit_price = $value['unit_price'];
    			$r->total_price = $value['total_price'];
    			if ($r->save()) {
                    array_push($orderItems, $r);
                    $i++;
                }
                $j++;
    		}
            if ($i == $j) {
                if (isset($charge)) {
                    try {
                        \Stripe\Stripe::setApiKey ( env('STRIPE_SECRET') );
                        try {

                            try {
                                $stripe = \Stripe\Charge::create([
                                  "amount" => $charge['amount'],
                                  "currency" => "usd",
                                  "source" => $charge['source'],
                                ]);
                            } catch (Exception $c) {
                                $a = Order::find($res->id)->delete();
                                $b = OrderItem::where('order_id', $res->id)->delete();
                                return $c;
                            }

                            // Session::flash ( 'success-message', 'Payment done successfully !' );
                            // return Redirect::back ();
                            // $res->stripe_charge = $stripe->id;
                            if ($stripe) {
                                // $res = Subscription::find($r->id);
                                // $res->stripe_charge = $stripe->id;
                                // $res->save();
                                $d = Order::find($res->id);
                                $d->stripe_id = $stripe->id;
                                $d->save();

                                $res->order_items = $orderItems;
                                Mail::to('acoleman@paifashion.com')
                                     ->send(new OrderConfirmed($res));

                                $result = 'success';
                                return compact('res', 'result');
                            }
                        } catch ( Exception $e ) {
                            $res = Subscription::find($r->id)->delete();
                            return 'error-credit';
                        }
                    } catch (Exception $c) {
                        return $c;
                    }
                }
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
