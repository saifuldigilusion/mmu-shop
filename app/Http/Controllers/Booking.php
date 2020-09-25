<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Booking as Book;
use App\OrderItem;
use App\Product;
use App\Schedule;
use App\ScheduleSlot;

class Booking extends Controller
{
    //
    public function bookByOrder(Request $request, $orderId) {

        $bookByOrder = true;
        $order = Order::where('orderid', $orderId)->where('status','PAID')->first();
        if($order) {
            $orderItems = OrderItem::where('order_id', $order->id)->where('booking', true)->get();
            if($orderItems->count()) {
                // check if booking already made with the order
                $booking = Book::where('order_id', $order->id);
                $schedules = array();
                $scheduleSlots = array(); 
                foreach($orderItems as $orderItem) {
                    $product = Product::find($orderItem->product_id);
                    $schedule = Schedule::find($product->schedule_id);

                }
                if($booking) {
                    // handle existing booking. show booking info
                }
                else {
                    $schedule = 
                    return view('store.booking', compact('bookByOrder', 'order'));
                }
            }
            else {
                $errorMsg = "The order $orderId do not require any reservation/booking.";
            }
        }
        else {
            $errorMsg = "The order $orderId is not valid or not yet paid.";
        }
        
        return view('shop.error', compact('errorMsg'));
    }
}
