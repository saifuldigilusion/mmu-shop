@extends('adminlte::page')  

@section('content_header')
    <h1>Order Items</h1>
@stop

@section('content')
<div class="row">
    <div class="col">
    <table id="order-table" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Order No</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Shipping</th>
                <th>Qty</th>
                <th>Require Booking</th>
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
            searching: true,
            paging: true,
            buttons: [
                    'csv', 'print',
            ],
            ajax: {
                'url':"{{ route('orderitem_list') }}",
                'type': 'POST',
                'headers': {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            order: [[0, 'desc']],
            pageLength: 25,
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'orderid', name: 'orderid'},
                {data: 'name', name: 'name', searchable: true, orderable: true},
                {data: 'description', name: 'description', searchable: false, orderable: false},
                {data: 'price', name: 'price', orderable: false, searchable: false},
                {data: 'shipping', name: 'shipping', orderable: false, searchable: false},
                {data: 'qty', name: 'qty', orderable: false, searchable: false},
                {data: 'a_booking', name: 'a_booking', orderable: false, searchable: false},
            ]
        });
  });
    
    </script>
@stop