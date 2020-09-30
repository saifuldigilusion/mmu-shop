<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\OrderItem;
use Yajra\DataTables\DataTables;
use App\Libraries\Helper;

class OrderController extends Controller
{
    //
    public function list(Request $request) {
        if ($request->ajax()) {
            $data = Order::latest()->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('admin.orderlist');
    }

    public function edit(Request $request) {
        $order = null;
        if($request->isMethod('post')) {
            if($request->input('id')) {
                $order = Order::find($request->input('id'));
                if($order) {
                    $order->status = $request->input('status');
                    $order->payment_channel = $request->input('payment_channel');
                    $order->payment_transactionid = $request->input('payment_transactionid');

                    $order->save();

                    //$orderItem = OrderItem::where('order_id', $order->id)->get();
                    //return view('admin.orderdetail', compact('order', 'orderItem'));

                    return redirect()->back()->with(['message' => 'Order updated', 'alert' => 'alert-success']);

                }
                else {
                    $errorMsg = "No order found.";
                    return view('admin.error', compact('errorMsg'));
                }
            }
        }

        $errorMsg = "No order found.";
        return view('admin.error', compact('errorMsg'));
    }

    public function itemList(Request $request) {
        if ($request->ajax()) {
            $data = OrderItem::latest()->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('a_booking', function($row){
                return $row->booking ? "Yes": "No";
            //    return $btn;
            })
            ->rawColumns(['a_booking'])
            ->make(true);
        }

        return view('admin.orderitemlist');
    }

    public function detail(Request $request, $orderId) {

        if ($request->ajax()) {
            $data = OrderItem::where('order_id', $orderId)->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('a_booking', function($row){
                return $row->booking ? "Yes": "No";
            //    return $btn;
            })
            ->rawColumns(['a_booking'])
            ->make(true);
        }

        $order = Order::find($orderId);
        if($order) {
            $orderItem = OrderItem::where('order_id', $order->id)->get();
            $statusOptions = Helper::getEnumValues('orders', 'status');
            $paymentChannels = config('mmucnergy.paymentChannels');
            return view('admin.orderdetail', compact('order', 'orderItem', 'statusOptions', 'paymentChannels'));
        }
        
        $errorMsg = "No order found.";
        return view('admin.error', compact('errorMsg'));
    }
}
