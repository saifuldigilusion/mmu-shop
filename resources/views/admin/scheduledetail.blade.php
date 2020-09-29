@extends('adminlte::page')

@section('content_header')
    <h1>Schedule</h1>
@stop

@php
 $id = 0;
 $name = "";
 $available = 0;

 $edit = false;
 if($schedule !== null) {
    $id = $schedule->id;
    $name = $schedule->name;
    $available = $schedule->available;

    $edit = true;
 }   
@endphp

@section('content')
<div class="card">
    <div class="card-header bg-secondary">Schedule Detail</div>
    <form class="form-horizontal needs-validation" id="form" method="POST" action="{{ route('schedule_add', [$id]) }}" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
    <div class="card-body">
        <div class="form-group row">
            <div class="col-md-6">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $name }}">
                <div class="invalid-feedback">
                    Require name
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="available">Enable</label>
                <select class="custom-select" id="available" name="available">
                    <option value="1" {{ $available ? "selected": ""}}>Yes</option>
                    <option value="0" {{ $available ? "": "selected"}}>No</option>
                </select>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
        <div class="float-right">
            <a href="{{ route('schedule_list') }}" class="btn btn-default">List</a>
            @if($edit)
                <a href="javascript:deleteRecord({{ $id }})" class="btn btn-default">Delete</a>
            @endif
        </div>
    </div>
    </form>
</div>

<div class="row">
    <div class="col">
    <table id="order-table" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Start Date</th>
                <th>Start Time</th>
                <th>End Date</th>
                <th>End Time</th>
                <th>Max Unit</th>
                <th>Unit Taken</th>
                <th>Enable</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>

    $(function () {
        
        var table = $('#order-table').DataTable({
            //dom: "<'row'<'col-sm-6'B><'col-sm-6'f>><'row'<'col-sm-12'tr>>",
            //dom: 'Bft',
            dom: '<"float-left"B><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
            processing: true,
            serverSide: true,
            searching: false,
            paging: false,
            buttons: [
                //'csv', 'print',
                {
                text: ' New Slot ',
                action: function(e, dt, node, config) {
                    window.location.href = "{{ route('scheduleslot_add',['scheduleId' => $id, 'scheduleSlotId' => '0']) }}";
                }
                },
            ],
            ajax: {
                'url':"{{ route('schedule_detail', ['scheduleId' => $id]) }}",
                'type': 'POST',
                'headers': {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            //order: [[0, 'desc']],
            //pageLength: 25,
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'start_date', name: 'start_date', searchable: true, orderable: true},
                {data: 'start_time', name: 'start_time', searchable: false, orderable: false},
                {data: 'end_date', name: 'end_date', searchable: false, orderable: true},
                {data: 'end_time', name: 'end_time', searchable: false, orderable: false},
                {data: 'qty_avai', name: 'qty_avai', orderable: false, searchable: false},
                {data: 'qty_taken', name: 'qty_take', orderable: false, searchable: false},
                {data: 'a_enable', name: 'a_enable', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        //table.buttons().container().appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
      });

    function deleteRecord(id) {
        if(confirm('Delete this record?')) {
        var form = document.createElement('form');
        document.body.appendChild(form);
        form.method = 'post';
        form.action = '{{ route("schedule_delete") }}';
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