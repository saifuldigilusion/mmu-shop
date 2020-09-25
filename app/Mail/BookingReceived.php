<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $orderItems;
    public $schedule;
    public $slot;
    public $booking;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $orderItems, $schedule,  $slot, $booking)
    {
        //
        $this->order = $order;
        $this->orderItems = $orderItems;
        $this->slot = $slot;
        $this->schedule = $schedule;
        $this->booking = $booking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $subject = "MMU Shop - Booking Details (" . $this->order->orderid . " )";
        return $this->subject($subject)->view('mails.booking.received', ['order' => $this->order, 'orderItems' => $this->orderItems, 'schedule' => $this->schedule, 'slot' => $this->slot, 'booking' => $this->booking]);
    }
}
