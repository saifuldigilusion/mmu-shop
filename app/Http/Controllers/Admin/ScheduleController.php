<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Schedule;
use App\ScheduleSlot;
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
            ->addColumn('a_enable', function($row){
                return $row->available ? "Yes": "No";
            })
            ->addColumn('action', function($row){
                // route('booking_edit', [$row->id])
                $btn = '<a href="' . route('schedule_detail', [$row->id]) . '"><i class="fas fa-fw fa-sticky-note"></i></a></a>';
                return $btn;
            })
            ->rawColumns(['a_enable','action'])
            ->make(true);
        }

        return view('admin.schedulelist');
    }

    public function detail(Request $request, $scheduleId) {

        if ($request->ajax()) {
            $data = ScheduleSlot::where('schedule_id', $scheduleId)->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('a_enable', function($row){
                return $row->available ? "Yes": "No";
            })
            ->addColumn('action', function($row){
                // route('booking_edit', [$row->id])
                $btn = '<a href="' . route('scheduleslot_add', [$row->schedule_id, $row->id]) .'"><i class="fas fa-fw fa-sticky-note"></i></a></a>';
                return $btn;
            })
            ->rawColumns(['a_enable','action'])
            ->make(true);
        }

        if($scheduleId == 0) {
            $schedule = null;
            $scheduleSlots = null;
            return view('admin.scheduledetail', compact('schedule', 'scheduleSlots'));
        }

        $schedule = Schedule::find($scheduleId);
        if($schedule) {
            $scheduleSlots = ScheduleSlot::where('schedule_id', $schedule->id)->get();
            return view('admin.scheduledetail', compact('schedule', 'scheduleSlots'));
        }

        $errorMsg = "No schedule found.";
        return view('admin.error', compact('errorMsg'));
    }

    public function add(Request $request) {
        $schedule = null;
        if($request->isMethod('post')) {
            if($request->input('id')) {
                $schedule = Schedule::find($request->input('id'));
            }
            else {
                $schedule = new Schedule;
            }
            $schedule->name = $request->input('name');
            $schedule->available = $request->input('available');

            $schedule->save();
            return view('admin.schedulelist');
        }

        $errorMsg = "No schedule found.";
        return view('admin.error', compact('errorMsg'));
    }

    public function delete(Request $request) {
        if($request->input('id')) {
            // check if product have order. do not allow
            $booking = Booking::where('schedule_id', $request->input('id'))->first();
            if($booking) {
                $errorMsg = "The schedule that your try to delete have booking record. Delete will break booking report. Instead of delete, DISABLE the schedule. ";
                return view('admin.error', compact('errorMsg'));
            }
            else {
                Schedule::destroy($request->input('id'));
                return view('admin.schedulelist');
            }
        }

        $errorMsg = "Error. You are not suppose to be here";
        return view('admin.error', compact('errorMsg'));
    }

    // ScheduleSlot //////////////////////////////////////////////////////////
    public function addSlot(Request $request, $scheduleId, $scheduleSlotId) {
        $scheduleSlot = null;
        $schedule = Schedule::find($scheduleId);
        if($schedule) {
            $scheduleSlot = ScheduleSlot::find($scheduleSlotId);
            if($request->isMethod('post')) {
                
                if($schedule) {
                    if($request->input('id')) {
                        $scheduleSlot = ScheduleSlot::find($request->input('id'));
                    }
                    else {
                        $scheduleSlot = new ScheduleSlot;
                    }

                    $slottime = $request->input('slottime');
                    if(strlen($slottime)) {
                        $slottimeAry = explode(" - ", $slottime);
                        if(count($slottimeAry) > 1) {
                            $slottimeS = explode(" ", $slottimeAry[0]);
                            $scheduleSlot->start_date = $slottimeS[0];
                            $scheduleSlot->start_time = $slottimeS[1];

                            $slottimeE = explode(" ", $slottimeAry[1]);
                            $scheduleSlot->end_date = $slottimeE[0];
                            $scheduleSlot->end_time = $slottimeE[1];
                        }
                    }

                    $scheduleSlot->schedule_id = $request->input('schedule_id');
                    //$scheduleSlot->start_date = $request->input('start_date');
                    //$scheduleSlot->start_time = $request->input('start_time');
                    //$scheduleSlot->end_date = $request->input('end_date');
                    //$scheduleSlot->end_time = $request->input('end_time');
                    $scheduleSlot->qty_avai = $request->input('qty_avai');
                    //$scheduleSlot->qty_taken = $request->input('qty_taken');
                    $scheduleSlot->available = $request->input('available');
                    $scheduleSlot->info = $request->input('info');

                    $scheduleSlot->save();
                    
                    $scheduleSlots = ScheduleSlot::where('schedule_id', $schedule->id)->get();
                    return view('admin.scheduledetail', compact('schedule', 'scheduleSlots'));
                }
            }
            return view('admin.scheduleslotadd', compact('scheduleSlot', 'schedule'));
        }
        else {
            $errorMsg = "You are trying to add schedule slot to non-exist schedule.";
            return view('admin.error', compact('errorMsg'));
        }
    }

    public function editSlot(Request $request, $id) {
        $scheduleSlot = ScheduleSlot::find($id);
        if($scheduleSlot) {
            $schedule = Schedule::find($scheduleSlot->schedule_id);
            return view('admin.scheduleslotadd', compact('scheduleSlot', 'schedule'));
        }
        $errorMsg = "Not found";
        return view('admin.error', compact('errorMsg'));
    }

    public function deleteSlot(Request $request) {
        if($request->input('id')) {
            // check if product have order. do not allow
            $booking = Booking::where('slot_id', $request->input('id'))->first();
            if($booking) {
                $errorMsg = "The slot that your try to delete have booking record. Delete will break booking report. Instead of delete, DISABLE the slot. ";
                return view('admin.error', compact('errorMsg'));
            }
            else {
                $scheduleSlot = ScheduleSlot::find($request->input('id'));
                ScheduleSlot::destroy($request->input('id'));

                return $this->detail($request, $scheduleSlot->schedule_id);
            }
        }

        $errorMsg = "Error. You are not suppose to be here";
        return view('admin.error', compact('errorMsg'));
    }
}
