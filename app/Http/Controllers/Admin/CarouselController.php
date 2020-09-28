<?php

namespace App\Http\Controllers\Admin;

use App\Carousel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;

class CarouselController extends Controller
{
    //
    public function list(Request $request) {
        if ($request->ajax()) {
            $data = Carousel::latest()->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="' . route('carousel_edit', [$row->id]) . '"><i class="fas fa-fw fa-sticky-note"></i></a></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('admin.carousellist');
    }

    public function add(Request $request) {
        $carousel = null;
        if($request->isMethod('post')) {
            if($request->input('id')) {
                $carousel = Carousel::find($request->input('id'));
            }
            else {
                $carousel = new Carousel;
            }
            $carousel->image = $request->input('image');
            $carousel->title = $request->input('title');
            $carousel->description = $request->input('description');
            $carousel->active = $request->input('active');

            $carousel->save();
            return view('admin.carousellist');
        }

        return view('admin.carouseladd', compact('carousel'));
    }

    public function edit(Request $request, $id) {
        $carousel = Carousel::find($id);
        if($carousel) {
            return view('admin.carouseladd', compact('carousel'));
        }
        $errorMsg = "Not found";
        return view('admin.error', compact('errorMsg'));
    }

    public function delete(Request $request) {
        if($request->input('id')) {
            Carousel::destroy($request->input('id'));
        }
        return view('admin.carousellist');
    }
}
