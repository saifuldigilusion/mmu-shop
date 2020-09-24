<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Order;
use App\OrderItem;

class Test extends Controller
{
    //1aslasita?
    public function sendmail() {

        $to = "saifulbahri@gmail.com";

        $order = Order::find(15);
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        $subject = "MMU Shop - Order Details (" . $order->orderid . ")";
        Mail::send('mails.order.received', ['order' => $order, 'orderItems' => $orderItems , 'logo' =>'','title' => '', 'store_name' => 'MMU Shop'], function ($message) use ($subject, $to){
            $message->to($to);
            $message->subject($subject);
        });
        
        
        //return view('mails.order.received',  ['order' => $order, 'orderItems' => $orderItems , 'logo' =>'','title' => '', 'store_name' => 'MMU Shop']);
    }
}
