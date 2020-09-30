<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Carousel;
use App\Category;
use Illuminate\Support\Facades\Log;

class Shop extends Controller
{
    //
    public function show(Request $request) {
        $products = Product::where('available', 1)->orderBy('order', 'ASC')->get();
        $carousels = Carousel::where('active', 1)->get();
        $categories = Category::get();
        return view('shop.main', compact('products', 'carousels', 'categories'));
    }

    public function showCategory(Request $request, $category) {
        $categories = Category::get();
        foreach($categories as $c) {
            $n = strtolower(str_replace(' ', '', $c->name));
            if($n == $category) {
                $products = Product::where('available', 1)->where('category_id', $c->id)->orderBy('order', 'ASC')->get();
                $carousels = Carousel::where('active', 1)->get();
                return view('shop.main', compact('products', 'carousels', 'categories'));
            }
        }
        abort(404);
    }

    public function productDetail(Request $request, $productId) {
        $product = Product::find($productId);
        if($product) {
            if($product->available) {
                $category = $this->getProductCategory($product);
                return view('shop.product', compact('product', 'category'));
            }
        }

        abort(404);
        
    }

    protected function getProductCategory($product) {
        $category = Category::find($product->category_id);
        if($category) {
            return $category->name;
        }

        return "";
    }
}
