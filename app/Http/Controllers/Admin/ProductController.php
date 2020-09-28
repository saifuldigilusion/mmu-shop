<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    //
    public function list(Request $request) {
        if ($request->ajax()) {
            $data = Product::latest()->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                // route('booking_edit', [$row->id])
                $btn = '<a href="' . route('product_edit', [$row->id]) .'"><i class="fas fa-fw fa-sticky-note"></i></a></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('admin.productlist');
    }

    public function add(Request $request) {
        $product = null;
        if($request->isMethod('post')) {
            if($request->input('id')) {
                $product = Product::find($request->input('id'));
            }
            else {
                $product = new Product;
            }
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->long_description = $request->input('long_description');
            $product->image = $request->input('image');
            $product->image_big = $request->input('image_big');
            $product->price = $request->input('price');
            $product->rrp_price = $request->input('rrp_price');
            $product->available = $request->input('available');
            $product->booking = $request->input('booking') ? 1:0;
            $product->schedule_id = $request->input('schedule_id');

            $product->save();
            return view('admin.productlist');
        }

        return view('admin.productadd', compact('product'));
    }

    public function edit(Request $request, $id) {
        $product = Product::find($id);
        if($product) {
            return view('admin.productadd', compact('product'));
        }
        $errorMsg = "Not found";
        return view('admin.error', compact('errorMsg'));
    }

    public function delete(Request $request) {
        if($request->input('id')) {
            Product::destroy($request->input('id'));
        }
        return view('admin.productlist');
    }
}
