<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Carousel;
use Illuminate\Support\Facades\Log;

class Shop extends Controller
{
    //
    public function show(Request $request) {
        $products = Product::where('available', 1)->get();
        $carousels = Carousel::where('active', 1)->get();
        return view('shop.main', compact('products', 'carousels'));
    }

    public function productDetail(Request $request, $productId) {
        $product = Product::find($productId);
        if($product) {
            if($product->available) {
                return view('shop.product', compact('product'));
            }
        }

        abort(404);
        
    }
}
