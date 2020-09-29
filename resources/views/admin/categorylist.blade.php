@extends('adminlte::page')  

@section('content_header')
    <h1>Category</h1>
@stop

@section('content')
<div class="row">
    <div class="col">
    <table id="order-table" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
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
        //dom: 'Bft',
        //dom: '<"float-left"B><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
        dom: '<"float-left"B><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
        processing: true,
        serverSide: true,
        buttons: [
            //'csv', 'print',
            {
            text: ' New ',
            action: function(e, dt, node, config) {
                window.location.href = "/admin/category/add";
            }
            },
        ],
        //ajax: "{{ route('order_list') }}",
        ajax: {
            'url':'{{ route('category_list') }}',
            'type': 'POST',
            'headers': {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        searching: false,
        order: [[0, 'desc']],
        pageLength: 25,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false,searchable: false},
        ]
    });
    //table.buttons().container().appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
  });
    
    </script>
@stop