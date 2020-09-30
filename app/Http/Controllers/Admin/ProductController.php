<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\OrderItem;
use App\Product;
use App\ProductDeliveryCost;
use App\Schedule;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    //
    public function list(Request $request) {
        if ($request->ajax()) {
            //$data = Product::latest()->get();
            $data = Product::latest('products.created_at')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.id as id',
                'products.name as name', 
                'products.description as description',
                'products.price as price',
                'products.rrp_price as rrp_price',
                'products.available as available',
                'products.order as order',
                'categories.name as category'
            )->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('a_enable', function($row){
                return $row->available ? "Yes": "No";
            })
            ->addColumn('action', function($row){
                // route('booking_edit', [$row->id])
                $btn = '<a href="' . route('product_edit', [$row->id]) .'"><i class="fas fa-fw fa-sticky-note"></i></a></a>';
                return $btn;
            })
            ->rawColumns(['action', 'a_enable'])
            ->make(true);
        }

        return view('admin.productlist');
    }

    public function add(Request $request) {
        $product = null;
        $productDeliveryCost = null;
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
            $product->schedule_id = $request->input('schedule_id');
            $product->booking = $product->schedule_id ? 1:0;
            $product->category_id = $request->input('category_id');
            $product->order = $request->input('order');
            $product->selfcollect = $request->input('selfcollect') == "on" ? 1:0;
            $product->delivery = $request->input('delivery') == "on" ? 1:0;

            $product->save();

            ProductDeliveryCost::where('product_id', $product->id)->delete();
            if($product->delivery) {
                foreach(config('mmucnergy.deliveryCostName') as $n => $v) {
                    $productDeliveryCost = new ProductDeliveryCost;
                    $productDeliveryCost->name = $n;
                    $productDeliveryCost->price = $request->input('p-' . str_replace(' ', '_', $n));
                    $productDeliveryCost->product_id = $product->id;

                    $productDeliveryCost->save();
                }
            }
            
            return view('admin.productlist');
        }

        $schedules = Schedule::where('available', 1)->get();
        $categories = Category::get();
        $deliveryCostName = config('mmucnergy.deliveryCostName');
        $productDeliveryCost = $this->getProductDeliveryCost($product);
        
        return view('admin.productadd', compact('product', 'productDeliveryCost', 'schedules', 'categories', 'deliveryCostName'));
    }

    public function edit(Request $request, $id) {
        $product = Product::find($id);
        if($product) {
            $schedules = Schedule::where('available', 1)->get();
            $categories = Category::get();
            $deliveryCostName = config('mmucnergy.deliveryCostName');
            $productDeliveryCost = $this->getProductDeliveryCost($product);
            return view('admin.productadd', compact('product', 'productDeliveryCost', 'schedules', 'categories', 'deliveryCostName'));
        }
        $errorMsg = "Not found";
        return view('admin.error', compact('errorMsg'));
    }

    protected function getProductDeliveryCost($product) {
        //$deliveryCostName = config('deliveryCostName');
        $r = config('mmucnergy.deliveryCostName');
        if($product != null) {
            $productDeliveryCost = ProductDeliveryCost::where('product_id', $product->id)->get();
            foreach($productDeliveryCost as $d) {
                $r[$d->name] = $d->price;
            }
        }
        return $r;
    }

    public function delete(Request $request) {
        if($request->input('id')) {
            // check if product have order. do not allow
            $orderItem = OrderItem::where('product_id', $request->input('id'))->first();
            if($orderItem) {
                $errorMsg = "The product that your try to delete have order record. Delete will break order report. Instead of delete, DISABLE the product. ";
                return view('admin.error', compact('errorMsg'));
            }
            else {
                Product::destroy($request->input('id'));
            }
        }
        return view('admin.productlist');
    }
}
