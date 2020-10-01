<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    //
    public function list(Request $request) {
        if ($request->ajax()) {
            $data = Category::latest()->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="' . route('category_edit', [$row->id]) . '"><i class="fas fa-fw fa-sticky-note"></i></a></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('admin.categorylist');
    }

    public function add(Request $request) {
        $category = null;
        if($request->isMethod('post')) {
            if($request->input('id')) {
                $category = Category::find($request->input('id'));
            }
            else {
                $category = new Category;
            }
            $category->name = $request->input('name');
            $category->image = $request->input('image');

            $category->save();
            return view('admin.categorylist');
        }

        return view('admin.categoryadd', compact('category'));
    }

    public function edit(Request $request, $id) {
        $category = Category::find($id);
        if($category) {
            return view('admin.categoryadd', compact('category'));
        }
        $errorMsg = "Not found";
        return view('admin.error', compact('errorMsg'));
    }

    public function delete(Request $request) {
        if($request->input('id')) {
            $product = Product::where('category_id', $request->input('id'))->first();
            if($product) {
                $errorMsg = "The category that your try to delete have product linked. Delete will break product link. Only category without any product linked to it can be deleted. ";
                return view('admin.error', compact('errorMsg'));
            }

            Category::destroy($request->input('id'));
        }
        return view('admin.categorylist');
    }
}
