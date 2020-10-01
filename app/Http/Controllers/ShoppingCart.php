<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Product;
use App\Order;
use App\OrderItem;
use App\ProductDeliveryCost;
use Exception;

class ShoppingCart extends Controller
{
    //
    public function add(Request $request) {
        
        $id = $request->input('id');
        $error = null;
        if($id) {
            $product = Product::find($id);
            if($product) {
                $item = array(
                    "id" => $product->id,
                    "name" => $product->name,
                    "qty" => 1,
                    "price" => $product->price,
                    "options" => $product->toArray(),
                    "taxrate" => 0
                );
                if($product->delivery) {
                    $productDeliveryCost = ProductDeliveryCost::where('product_id', $product->id)->get();
                    $a = array();
                    foreach($productDeliveryCost as $p) {
                        $a[] = $p;
                    }
                    $item["options"]["delivery_cost"] = $a;
                }
                Cart::add($item);
            }
            else {
                $error = "The item you choosed no longer available";
            }
        }
        else {
            $error = "Nothing to add";
        }
        return $this->view($error);
    }

    public function list(Request $request) {

        $sessionId = session()->getId(); 
        return Cart::content();
    }

    public function update(Request $request) {

        $error = null;
        $rowId =  $request->input('row');
        $qty = $request->input('qty');
        if($rowId) {
            $r = Cart::get($rowId);
            try {
                Cart::update($rowId, $qty);
            }
            catch(Exception $e) {
                $error = "Item not exist";
            }
            
        }

        return $this->view($error);
    }


    public function remove(Request $request) {
        $error = null;
        $rowId =  $request->input('row');
        if($rowId) {
            try {
                Cart::remove($rowId);
            }
            catch(Exception $e) {
                $error = "Item not exist";
            }
        }
        return $this->view($error);
    }

    public function clear(Request $request) {
        Cart::destroy();

        $error = null;
        return $this->view($error);
    }

    public function show(Request $request) {
        $error = null;
        return $this->view($error);
    }

    public function view($error) {
        $items = Cart::content();
        $total = Cart::total();
        $count = Cart::count();
        return view('shop.cart', compact('items', 'error', 'count', 'total'));
    }

    public function checkoutConfirm(Request $request) {

        // store into db
        if(Cart::count() > 0) {

            $checkoutInfo = array();

            $checkoutInfo["name"] = $request->input('name');
            $checkoutInfo["email"]  = $request->input('email');
            $checkoutInfo["phone"] = $request->input('phone');
            $checkoutInfo["studentid"]  = $request->input('studentid');

            $checkoutInfo["delivery"]  = 1 * ($request->input('delivery'));
            $checkoutInfo["address"]  = $request->input('address');
            $checkoutInfo["address2"]  = $request->input('address2');
            $checkoutInfo["postcode"]  = $request->input('postcode');
            $checkoutInfo["state"]  = $request->input('state');

            //session(['checkoutinfo' => json_encode($checkoutInfo)]);
            //Log::debug(json_encode($checkoutInfo));

            $items = Cart::content();
            $total = Cart::total();
            $count = Cart::count();

            $deliveryCharges = array();
            $totalDeliveryCharges = 0.00;
            if($checkoutInfo["delivery"]) {
                $malaysiaStates = config('mmucnergy.malaysiaStates');
                $eastWestMalaysia = $malaysiaStates[$checkoutInfo["state"]];
                foreach($items as $i) {
                    if($i->options["delivery"]) {
                        $productDeliveryCost = ProductDeliveryCost::where('product_id', $i->id)->where('name', $eastWestMalaysia)->first();
                        if($productDeliveryCost) {
                            $deliveryCost = $productDeliveryCost->price * $i->qty;
                            $totalDeliveryCharges = $totalDeliveryCharges + $deliveryCost;
                            $deliveryCharges[$i->id] = $deliveryCost;
                        }
                    }
                }
            }
            $error = null;
            return view('shop.cartconfirm', compact('items', 'error', 'count', 'total', 'checkoutInfo', 'deliveryCharges', 'totalDeliveryCharges'));
        }

        $error = null;
        return $this->view($error);
    }

    public function checkout(Request $request) {

        // store into db
        if(Cart::count() > 0) {

            $order = new Order();
            $order->date = date('Y-m-d');
            $order->item_count = Cart::count();
            $order->sub_total = Cart::subtotal();
            $order->tax = Cart::tax();
            $order->total = Cart::total();

            $order->name = $request->input('name');
            $order->email = $request->input('email');
            $order->phone = $request->input('phone');
            $order->studentid = $request->input('studentid');

            $order->delivery  = 1 * ($request->input('delivery'));
            $order->address  = $request->input('address');
            $order->address2  = $request->input('address2');
            $order->postcode  = $request->input('postcode');
            $order->state  = $request->input('state');

            // creating order ID
            $order->save();

            $orderId = $order->id + time();
            $order->orderid = strtoupper(dechex($orderId));
            $order->save();

            $deliveryCharges = array();
            $totalDeliveryCharges = 0.00;

            $malaysiaStates = config('mmucnergy.malaysiaStates');
            $eastWestMalaysia = "East Malaysia";
            if($order->delivery) {
                $eastWestMalaysia = $malaysiaStates[$order->state];
            }
            $items = Cart::content();
            foreach($items as $item) {
                $oi = new OrderItem();
                $oi->order_id = $order->id;
                $oi->orderid = $order->orderid;
                $oi->product_id = $item->id;
                $oi->name = $item->name;
                $oi->description = $item->options["description"];
                $oi->image = $item->options["image"];
                $oi->price = $item->price;
                $oi->qty = $item->qty;
                $oi->booking = $item->options["booking"];

                if($order->delivery) {
                    $productDeliveryCost = ProductDeliveryCost::where('product_id', $item->id)->where('name', $eastWestMalaysia)->first();
                    if($productDeliveryCost) {
                        $deliveryCost = $productDeliveryCost->price * $item->qty;
                        $totalDeliveryCharges = $totalDeliveryCharges + $deliveryCost;
                        $deliveryCharges[$item->id] = $deliveryCost;

                        $oi->shipping = $productDeliveryCost->price;
                    }
                }

                $oi->save();
            }
            $order->shipping = $totalDeliveryCharges;
            $order->total = $order->total + $order->shipping;
            $order->save();

            Cart::destroy();

            $detail = config('senangpay.detail');
            $senangPaySecret = config('senangpay.secretKey');
            $senangPayMerchantId = config('senangpay.merchantId');
            $str = $senangPaySecret . $detail . $order->total . $order->orderid;
            $hash = hash_hmac('SHA256', $str, $senangPaySecret);
            $directParam = array(
                "detail" => $detail,
                "amount" => $order->total + $order->shipping,
                "order_id" => $order->orderid,
                "hash" => $hash,
                "name" => $order->name,
                "email" => $order->email,
                "phone" => $order->phone
            );

            return redirect(config('senangpay.url') . $senangPayMerchantId . '?' . http_build_query($directParam));
        }

        $error = null;
        return $this->view($error);
    }

    public function senangpay(Request $request) {
        $orderId = $request->input('order_id');
        $transactionId = "14363538840";
        
        $okhash = hash_hmac('SHA256', config('senangpay.secretKey')."1". $orderId . $transactionId . "Payment_was_successful" , config('senangpay.secretKey')); 
        $errhash = hash_hmac('SHA256', config('senangpay.secretKey')."0". $orderId . $transactionId . "Payment_was_failed" , config('senangpay.secretKey')); 
        
        $okurl = array(
            "status_id" => "1",
            "order_id" => $orderId,
            "transaction_id" => $transactionId,
            "msg" => "Payment_was_successful",
            "hash" => $okhash
        );
        $okurl = "/payment/senangpay/return?" . http_build_query($okurl);

        $errurl = array(
            "status_id" => "1",
            "order_id" => $orderId,
            "transaction_id" => $transactionId,
            "msg" => "Payment_was_successful",
            "hash" => $errhash
        );
        $errurl = "/payment/senangpay/return?" . http_build_query($errurl);

        return view('senangpay', compact('okurl', 'errurl' ));
    }
}
