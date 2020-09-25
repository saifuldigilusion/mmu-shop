<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Booking as Book;
use App\OrderItem;
use App\Product;
use App\Schedule;
use App\ScheduleSlot;
use App\Mail\BookingReceived;
use Illuminate\Support\Facades\Mail;

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
                    if($product->booking) {
                        $schedule = Schedule::find($product->schedule_id);
                        $schedules[$orderItem->id] = $schedule;
                        $scheduleSlot = ScheduleSlot::where('schedule_id', $schedule->id)->get();
                        $scheduleSlots[$orderItem->id] = $scheduleSlot;
                    }
                }
                if(count($schedules) > 0) {
                    return view('shop.booking', compact('bookByOrder', 'order', 'booking', 'schedules', 'scheduleSlots', 'orderItems'));
                }
                else {
                    $errorMsg = "The order $orderId do not require any reservation/booking.";
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

    public function bookSubmitByOrder(Request $request) {

        $orderId = $request->input('orderid');
        $orderItemId = $request->input('orderitem');
        $slotId = $request->input('slot');
        $scheduleId = $request->input('scheduleid');

        $order = Order::where('orderid', $orderId)->first();
        if($order) {
            // check if booking has been made
            $booking = Book::where('order_id', $orderId)->where('order_item_id', $orderItemId)->first();
            if($booking->count()) {
                $schedule = Schedule::find($scheduleId);
                $orderItem = OrderItem::find($orderItemId);
                $scheduleSlot = ScheduleSlot::find($booking->slot_id);
                return view('shop.bookingreceived', compact('order', 'orderItem', 'schedule', 'scheduleSlot', 'booking'));
            }
            else {
                $scheduleSlot = ScheduleSlot::find($slotId);
                if($scheduleSlot) {
                    $dt = date_format(date_create($scheduleSlot->start_date . " " . $scheduleSlot->start_time),"D d/m/Y H:i:s"); 
                    if($scheduleSlot->available) {
                        $schedule = Schedule::find($scheduleId);
                        $orderItem = OrderItem::find($orderItemId);

                        $booking = new Book();
                        $booking->schedule_id = $schedule->id;
                        $booking->slot_id = $scheduleSlot->id;
                        $booking->order_id = $order->id;
                        $booking->order_item_id = $orderItemId;
                        $booking->name = $order->name;
                        $booking->phone = $order->phone;
                        $booking->email = $order->email;

                        $booking->save();

                        $bookingId = $booking->id + time();
                        $booking->bookingid = strtoupper(dechex($bookingId));
                        $booking->save();

                        $scheduleSlot->qty_taken = $scheduleSlot->qty_taken + 1;
                        if($scheduleSlot->qty_taken >= $scheduleSlot->qty_avai) {
                            $scheduleSlot->available = 0;
                        }
                        $scheduleSlot->save();

                        if(config('mmucnerfy.salesEmailEnable')) {
                            $saleContact = config('mmucnergy.salesContact', '');
                            Mail::to($order->email)->bcc($saleContact)->send(new BookingReceived($order, $orderItem, $schedule, $scheduleSlot, $booking));
                        }
                        return view('shop.bookingreceived', compact('order', 'orderItem', 'schedule', 'scheduleSlot', 'booking'));
                    }
                    else {
                        $errorMsg = "The slot <strong>$dt</strong> you choose is fully booked and not available.";
                    }
                }
                else {
                    $errorMsg = "The slot you choose is not available.";
                }
            }
            
            $errorMsg = $errorMsg . "<br><br><a href=\"/reservation/byorder/$orderId\">Please try again</a>";
        }
        else {
            $errorMsg = "The order $orderId is not valid or not yet paid.";
        }

        return view('shop.error', compact('errorMsg'));
    }
}
