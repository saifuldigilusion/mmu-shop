<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Schedule;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ScheduleController extends Controller
{
    //
    public function list(Request $request) {
        if ($request->ajax()) {
            $data = Schedule::latest()->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                // route('booking_edit', [$row->id])
                $btn = '<a href=""><i class="fas fa-fw fa-sticky-note"></i></a></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('admin.schedulelist');
    }
}
