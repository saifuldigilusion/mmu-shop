@extends('adminlte::page')

@section('content_header')
    <h1>Schedule Slot</h1>
@stop

@php
 $id = 0;
 $schedule_id = $schedule->id;
 $start_date = date("Y-m-d");
 $start_time = date("H") . "00:00";
 $end_date = date("Y-m-d");
 $end_time = date("H", time() + (60*60)) . "00:00";
 $qty_avai = 0;
 $qty_taken = 0;
 $available = 0;
 $info = "";

 $edit = false;
 if($scheduleSlot !== null) {
    $id = $scheduleSlot->id;
    $schedule_id = $scheduleSlot->schedule_id;
    $start_date = $scheduleSlot->start_date;
    $start_time = $scheduleSlot->start_time;
    $end_date = $scheduleSlot->end_date;
    $end_time = $scheduleSlot->end_time;
    $qty_avai = $scheduleSlot->qty_avai;
    $qty_taken = $scheduleSlot->qty_taken;
    $available = $scheduleSlot->available;
    $info = $scheduleSlot->info;

    $edit = true;
 }   
@endphp

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Schedule Slot</h3>
            </div>
            <form class="form-horizontal needs-validation" id="form" method="POST" action="{{ route('scheduleslot_add', [$schedule_id, $id]) }}" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ $id }}">
            <input type="hidden" name="schedule_id" value="{{ $schedule_id }}">
            <div class="card-body">
                <div class="form-group row">
                    Slot for {{ $schedule->name }}
                </div>
                <div class="form-group row">
                    <label for="slottime">Date</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-clock"></i></span>
                        </div>
                    <input type="text" class="form-control float-right" id="slottime" name="slottime" value="{{ $start_date . " " . $start_time . " - " . $end_date . " " . $end_time}}" {{ $edit ? "disabled": "" }}>
                    </div>
                    <div class="invalid-feedback">
                        Require start date
                    </div>
                </div>
                <div class="form-group row">
                    <label for="qty_avai">Max Unit</label>
                    <input type="number" min="0" class="form-control" id="qty_avai" name="qty_avai" value="{{ $qty_avai }}">
                </div>
                <div class="form-group row">
                    <label for="qty_taken">Unit Taken</label>
                    <input type="number" min="0" class="form-control" id="qty_taken" name="qty_taken" value="{{ $qty_taken }}" {{ $edit ? "disabled": "" }}>
                </div>
                <div class="form-group row">
                    <label for="available">Enable</label>
                    <select class="custom-select" id="available" name="available">
                        <option value="1" {{ $available ? "selected": ""}}>Yes</option>
                        <option value="0" {{ $available ? "": "selected"}}>No</option>
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <div class="float-right">
                <a href="{{ route('schedule_detail', [$schedule_id]) }}" class="btn btn-default">List</a>
                @if($edit)
                    <a href="javascript:deleteRecord({{ $id }})" class="btn btn-default">Delete</a>
                @endif
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@stop

@section('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>

(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);

    $("#slottime").daterangepicker({
        timePicker: true,
        timePickerIncrement: 60,
        locale: {
            format: 'YYYY-MM-DD HH:mm:ss'
        }
    });
})();

function deleteRecord(id) {
        if(confirm('Delete this record?')) {
        var form = document.createElement('form');
        document.body.appendChild(form);
        form.method = 'post';
        form.action = '{{ route("scheduleslot_delete") }}';
        data = { text: 'delete', _token: $('meta[name="csrf-token"]').attr('content'), id: id}
        for (var name in data) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = data[name];
            form.appendChild(input);
        }
        form.submit();
    }
}

</script>
@stop