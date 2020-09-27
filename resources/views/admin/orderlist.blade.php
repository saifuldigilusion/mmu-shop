@extends('adminlte::page')  

@section('content_header')
    <h1>Order</h1>
@stop

@section('content')
<div class="row">
    <div class="col">
    <table id="order-table" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>OrderNo</th>
                <th>Date</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Qty</th>
                <th>Amount</th>
                <th>Status</th>
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
        buttons: [
                'csv', 'print',
        ],
        //ajax: "{{ route('order_list') }}",
        ajax: {
            'url':'{{ route('order_list') }}',
            'type': 'POST',
            'headers': {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        order: [[0, 'desc']],
        pageLength: 25,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'orderid', name: 'orderid', orderable: false},
            {data: 'date', name: 'date'},
            {data: 'name', name: 'name', orderable: false},
            {data: 'email', name: 'email', orderable: false},
            {data: 'phone', name: 'phone', orderable: false,},
            {data: 'item_count', name: 'item_count', searchable: false},
            {data: 'total', name: 'total'},
            {data: 'status', name: 'status'},
            {
                data: 'id', 
                name: 'action', 
                orderable: false, 
                searchable: false,
                render: function(data, type, row, meta) {
                    console.log( data + ' ' + type + ' ' + row + ' ' + meta);
                    return type === 'display' ? '<a href="/admin/order/detail/'+ data +'" ><i class="fas fa-fw fa-sticky-note"></i></a>' : data; 
                    
                }
            },
        ]
    });
    table.buttons().container().appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
  });
    
    </script>
@stop