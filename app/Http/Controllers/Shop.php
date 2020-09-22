<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Log;

class Shop extends Controller
{
    //
    public function show(Request $request) {
        $products = Product::where('available', 1)->get();
        return view('shop', compact('products'));
    }
}
