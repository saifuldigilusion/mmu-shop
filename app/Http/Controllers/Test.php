<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Test extends Controller
{
    //1aslasita?
    public function sendmail() {

        $subject = "test subject";
        $to = "Saiful Bahri <saifulbahri@gmail.com>";

        Mail::send('mails.order.received', ['content' => '', 'logo' =>'','title' => '', 'branch_name' => ''], function ($message) use ($subject, $to){
            $message->from('support@digilusion.com', 'Support Digilusion');
            $message->to('saifulbahri@gmail.com');
            $message->subject('Email Subject');
         });
    }
}
