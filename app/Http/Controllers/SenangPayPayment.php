<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderItem;
use App\Mail\OrderReceived;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Gloudemans\Shoppingcart\Facades\Cart;
use PhpParser\Node\Expr\Throw_;

class SenangPayPayment extends Controller
{
    //
    public function return_(Request $request) {

        $statusId = $request->input('status_id'); // 1 success, 0 failed
        $orderId = $request->input('order_id');
        $msg = $request->input('msg');
        $transactionId = $request->input('transaction_id');
        $hash = $request->input('hash');

        if($hash) {
            $senangPaySecret = config('senangpay.secretKey');
            $str = $senangPaySecret . $statusId . $orderId . $transactionId . $msg;
            $hash_ = hash_hmac('SHA256', $str, $senangPaySecret);
            if(strcmp($hash_, $hash) == 0) {
                
                // get the order detail
                $order = Order::where('orderid', $orderId)->first();
                if($order) {
                    $order->payment_channel = "SENANGPAY";
                    $order->payment_status = $statusId;
                    $order->payment_msg = $msg;
                    $order->payment_transactionid = $transactionId;
                    $order->payment_timestamp = date("Y-m-d H:i:s");
                    $status = "PAYMENT_FAILED";
                    if($statusId == 1) {
                        $status = "PAID";
                    } 
                    $order->status = $status;
                    $order->save();

                    $orderItems = OrderItem::where('order_id', $order->id)->get();
                    if(config('mmucnergy.salesEmailEnable')) {
                        $saleContact = config('mmucnergy.salesContact', '');
                        try {
                            Mail::to($order->email)->bcc($saleContact)->send(new OrderReceived($order, $orderItems));
                        }
                        catch(\Throwable $e) {
                            report($e);
                        }
                    }
                    return view('shop.payment', compact('statusId', 'msg', 'transactionId', 'order', 'orderItems'));
                }
                else {
                    return view('shop.payment_invalid');
                }
            }
            else {
                return view('shop.payment_invalid');
            }
        }

    }

    public function callback(Request $request) {
        Log::debug("Senangpay callback");
        Log::debug($request->all());
    }
}
